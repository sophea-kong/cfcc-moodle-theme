
# Configuring Moodle to Use the Local Jobe Server

This document explains how to configure Moodle to use the local Jobe server instead of the public server from the University of Canterbury.

## 🚀 Automatic Configuration (Recommended)

The changes are **automatically applied** when the Moodle container starts, thanks to the `docker-entrypoint.sh` script.

### Initial startup

```bash
cd moodle_docker
docker-compose up -d
```

Wait about 30 seconds for the installation and configuration to complete.

### Restart after shutdown

```bash
docker-compose down
docker-compose up -d
```

The changes will be **automatically reapplied** at each startup.

## 🔧 Manual configuration (if needed)

If you need to reapply the configuration manually:

```bash
cd moodle_docker
bash configure-jobe.sh
```

This script:

1. ✅ Adds cURL configuration in `config.php`
2. ✅ Patches the `curl_security_helper.php` file to disable URL blocking
3. ✅ Configures the Jobe server in the database
4. ✅ Clears the Moodle cache

## 📋 Applied changes

### 1. cURL configuration (`config.php`)

The following lines are added to `/var/www/html/config.php`:

```php
// Configuration to allow connection to the local Jobe server
$CFG->curlsecurityblockedhosts = '';
$CFG->curlsecurityallowedport = '80:443,4000:4999';
```

### 2. cURL security patch

Modification of `/var/www/html/lib/classes/files/curl_security_helper.php`:

```php
public function is_enabled() {
    return false; // PATCH: Disable cURL security for local Jobe
}
```

⚠️ **Warning**: This patch completely disables Moodle’s cURL security.
**Use only in a local development environment!**

### 3. Database configuration

Configuration in the `mdl_config_plugins` table:

| Plugin           | Name                | Value   |
| ---------------- | ------------------- | ------- |
| qtype_coderunner | jobe_host           | jobe:80 |
| qtype_coderunner | jobesandbox_enabled | 1       |
| qtype_coderunner | jobe_apikey         | (empty) |

## 🧪 Verification

To check that everything works:

1. **Access Moodle**: [http://localhost:8080](http://localhost:8080)

   * Username: `admin`
   * Password: `Admin123!`

2. **Create or preview a CodeRunner question**

3. **Check that the message "University of Canterbury" no longer appears**

4. **Monitor Jobe logs**:

   ```bash
   docker logs moodle_jobe -f
   ```

   You should see POST requests coming from `192.168.0.X` (the Moodle container)

## 🔍 Troubleshooting

### "URL is blocked" message appears

If you see this message after a restart:

```bash
cd moodle_docker
bash configure-jobe.sh
```

### Check Jobe configuration in the database

```bash
docker exec moodle_db mysql -u moodleuser -pmoodlepass moodle -e \
  "SELECT name, value FROM mdl_config_plugins WHERE plugin='qtype_coderunner' AND name LIKE '%jobe%';"
```

You should see:

```
name                    value
jobe_host               jobe:80
jobesandbox_enabled     1
jobe_apikey
```

### Check that Jobe is working

```bash
# From your host machine
curl http://localhost:4000/jobe/index.php/restapi/languages

# From the Moodle container
docker exec moodle_app curl http://jobe/jobe/index.php/restapi/languages
```

Both commands should return a list of languages in JSON format.

## 📁 File structure

```
moodle_docker/
├── docker-compose.yml          # Docker configuration
├── Dockerfile                  # Custom Moodle image
├── docker-entrypoint.sh        # Startup script (with automatic Jobe config)
├── configure-jobe.sh           # Manual configuration script
└── CONFIGURATION_JOBE.md       # This documentation
```

## ⚠️ Security warning

The applied changes **disable Moodle’s cURL security protections**.

* ✅ **OK for local development**
* ❌ **NEVER use in production**

In production, use:

* The public Jobe server from Canterbury, or
* A Jobe server with a public URL and a valid SSL certificate

## 🔄 Full reset

To start from scratch (deletes all data!):

```bash
cd moodle_docker
docker-compose down -v
docker-compose up -d
```

The configurations will be automatically reapplied.
