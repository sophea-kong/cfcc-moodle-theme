# Moodle + CodeRunner + Jobe Environment (Docker)

Docker environment to develop and test CodeRunner questions for Moodle locally.

## Architecture

* **Moodle 4.1**: Learning platform
* **CodeRunner**: Programming question plugin for Moodle (installed automatically)
* **Jobe**: Code execution server (sandbox)
* **MySQL 8.0**: Database

## Quick Start

### 1. Start the environment

```bash
# First use or after modifying the Dockerfile
docker-compose build --no-cache
docker-compose up -d
```

The first startup may take a few minutes (image downloads and initialization).

> **Important**: If you have already used this environment before, it is recommended to remove existing volumes to start from a clean installation:
>
> ```bash
> docker-compose down -v
> docker-compose build --no-cache
> docker-compose up -d
> ```

### 2. Access Moodle

* **URL**: [http://localhost:8080](http://localhost:8080)
* **Username**: admin
* **Password**: Admin123!

> **Note**: The first startup takes a few minutes because the system automatically installs Moodle, CodeRunner, and configures Jobe. Wait until the logs show "Starting Apache..." before logging in.

### 3. Verify CodeRunner installation (automatic)

**CodeRunner and Jobe are installed and configured automatically!** You can verify:

1. Log in to Moodle
2. Go to **Site administration > Plugins > Question types > CodeRunner**
3. Check that the Jobe server is configured as `http://jobe:80`
4. Click **Test connection** to verify everything works

### 4. Create a course

1. Click on **Site administration > Courses > Manage courses and categories**
2. Create a new category (e.g., "Python")
3. Create a new course (e.g., "Python Exercises")

## Usage

### Import a question bank

1. In your course, go to **Question bank**
2. Click on **Import**
3. Choose the **Moodle XML** format
4. Import your XML file containing CodeRunner questions
   (generated with the python_to_moodle tool)

### Test Jobe directly

Verify that Jobe works:

```bash
curl -X POST http://localhost:4000/jobe/index.php/restapi/runs \
  -H "Content-Type: application/json" \
  -d '{
    "run_spec": {
      "language_id": "python3",
      "sourcefilename": "test.py",
      "sourcecode": "print(\"Hello from Jobe!\")"
    }
  }'
```

### Stop the environment

```bash
docker-compose down
```

### Delete all data (full reset)

```bash
docker-compose down -v
```

## Ports used

* **8080**: Moodle HTTP
* **8443**: Moodle HTTPS
* **4000**: Jobe (direct access for testing)

## Persistent volumes

Data is stored in Docker volumes:

* `mariadb_data`: Database
* `moodle_data`: Moodle files
* `moodledata`: User data
* `jobe_data`: Jobe cache

## Recommended workflow with python_to_moodle

1. **Develop** your Python questions in `../python_to_moodle/`
2. **Generate the XML** using the python_to_moodle tool
3. **Start this environment**: `docker-compose up -d`
4. **Import the XML** into the Moodle question bank
5. **Test** the questions with different student code
6. **Adjust** if necessary and regenerate the XML
7. **Validate** that everything works correctly
8. **Deploy** to your production Moodle

## Automatic CodeRunner installation

The environment is configured to automatically install and configure CodeRunner:

### During Docker build

1. CodeRunner plugin v5.2.1 (compatible with Moodle 4.1) is downloaded from GitHub
2. It is installed in `/var/www/html/question/type/coderunner`
3. The behaviour `adaptive_adapted_for_coderunner` is also installed automatically

### On first startup

1. Moodle is installed with the database
2. The installation script detects the CodeRunner plugin and installs it automatically
3. Jobe configuration is automatically updated in the database:

   * `jobe_host` = `http://jobe:80`
   * `jobesandbox_enabled` = `1`
4. cURL security restrictions are disabled to allow connection to Jobe

The "Check" button should work immediately after installation!

### Manual verification

To check everything is properly configured:

```bash
# View installation logs
docker logs moodle_app

# You should see:
# - "Installing Moodle plugins (CodeRunner)..."
# - "Plugins installation complete!"
# - "Jobe server configured for CodeRunner!"
```

## Troubleshooting

### "no such file or directory" error at startup

If you get the error `exec /usr/local/bin/docker-entrypoint.sh: no such file or directory`:

**Cause**: The `docker-entrypoint.sh` file has Windows line endings (CRLF) instead of Unix (LF).

**Solution**:

```bash
# Convert line endings (if you have dos2unix)
dos2unix moodle_docker/docker-entrypoint.sh

# OR alternative without dos2unix
sed -i 's/\r$//' moodle_docker/docker-entrypoint.sh

# Then rebuild the Docker image
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

**Prevention**: The `.gitattributes` file at the root of the project automatically enforces LF line endings for shell files.

### Moodle does not start

Check the logs:

```bash
docker-compose logs moodle
```

### Jobe does not respond

Check that the container is running:

```bash
docker-compose ps
docker-compose logs jobe
```

### Permission issues

On Linux/Mac, you may need to adjust permissions:

```bash
sudo chown -R 1001:1001 ./volumes
```

### CodeRunner is not installed

If CodeRunner does not appear in plugins:

1. Check logs: `docker logs moodle_app`
2. Reinstall manually from the container:

```bash
docker exec -it moodle_app bash
cd /var/www/html
php admin/cli/upgrade.php --non-interactive
```

### Jobe cannot connect to CodeRunner

1. Check that Jobe is working:

```bash
curl http://localhost:4000/jobe/index.php/restapi/languages
```

2. Test connection from the Moodle container:

```bash
docker exec -it moodle_app curl http://jobe:80/jobe/index.php/restapi/languages
```

3. If the connection fails, check database settings:

```bash
docker exec -it moodle_app bash
mysql -hmysql -umoodleuser -pmoodlepass moodle -e "SELECT * FROM mdl_config_plugins WHERE plugin='qtype_coderunner';"
```

### Error during XML import

* Check that the XML format is correct
* Ensure CodeRunner is properly installed
* Check Moodle logs for more details

## Resources

* CodeRunner Documentation: [https://coderunner.org.nz/](https://coderunner.org.nz/)
* Jobe Documentation: [https://github.com/trampgeek/jobe](https://github.com/trampgeek/jobe)
* Moodle Docs: [https://docs.moodle.org/](https://docs.moodle.org/)