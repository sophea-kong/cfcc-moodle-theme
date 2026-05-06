#!/bin/bash
# Script to configure Moodle to use the local Jobe server
# This script can be run manually if needed

set -e

echo "=========================================="
echo "Configuring Moodle for local Jobe"
echo "=========================================="

# Check that the Moodle container is running
if ! docker ps | grep -q moodle_app; then
    echo "Error: The moodle_app container is not running."
    echo "Run 'docker-compose up -d' first."
    exit 1
fi

echo "1. Adding cURL configuration to config.php..."
docker exec moodle_app bash -c "
if ! grep -q 'curlsecurityblockedhosts' /var/www/html/config.php; then
    sed -i \"/require_once(__DIR__ . '\/lib\/setup.php');/i \\\\
// Configuration to allow connection to the local Jobe server\\\\
\\\$CFG->curlsecurityblockedhosts = '';\\\\
\\\$CFG->curlsecurityallowedport = '80:443,4000:4999';\\\\
\" /var/www/html/config.php
    echo '   ✓ cURL configuration added'
else
    echo '   ℹ cURL configuration already present'
fi
"

echo "2. Patching curl_security_helper.php file..."
docker exec moodle_app bash -c "
if [ -f '/var/www/html/lib/classes/files/curl_security_helper.php' ]; then
    if ! grep -q 'PATCH: Disable cURL security' /var/www/html/lib/classes/files/curl_security_helper.php; then
        # Backup
        cp /var/www/html/lib/classes/files/curl_security_helper.php \
           /var/www/html/lib/classes/files/curl_security_helper.php.backup

        # Patch
        sed -i '/public function is_enabled() {/!b;n;c\        return false; \/\/ PATCH: Disable cURL security for local Jobe' \
            /var/www/html/lib/classes/files/curl_security_helper.php
        echo '   ✓ File patched'
    else
        echo '   ℹ File already patched'
    fi
fi
"

echo "3. Configuring Jobe server in the database..."
docker exec moodle_db mysql -u moodleuser -pmoodlepass moodle --skip-ssl <<EOSQL 2>/dev/null
INSERT INTO mdl_config_plugins (plugin, name, value)
VALUES ('qtype_coderunner', 'jobe_host', 'jobe:80')
ON DUPLICATE KEY UPDATE value='jobe:80';

INSERT INTO mdl_config_plugins (plugin, name, value)
VALUES ('qtype_coderunner', 'jobesandbox_enabled', '1')
ON DUPLICATE KEY UPDATE value='1';

INSERT INTO mdl_config_plugins (plugin, name, value)
VALUES ('qtype_coderunner', 'jobe_apikey', '')
ON DUPLICATE KEY UPDATE value='';
EOSQL

if [ $? -eq 0 ]; then
    echo "   ✓ Database configuration completed"
else
    echo "   ⚠ Error during database configuration"
fi

echo "4. Clearing Moodle cache..."
docker exec moodle_app bash -c "cd /var/www/html && php admin/cli/purge_caches.php" 2>/dev/null
if [ $? -eq 0 ]; then
    echo "   ✓ Cache cleared"
else
    echo "   ⚠ Unable to clear cache"
fi

echo ""
echo "=========================================="
echo "✅ Configuration completed successfully!"
echo "=========================================="
echo ""
echo "Your Moodle is now using the local Jobe server (jobe:80)"
echo "Access Moodle: http://localhost:8080"
echo "  - Username: admin"
echo "  - Password: Admin123!"
echo ""