#!/bin/bash
# Финальная обработка специальных случаев

cd /workspace/WindLand

# inc/locations/merit.php - многострочные mysql_query
if [ -f "inc/locations/merit.php" ]; then
    # Заменяем все mysql_query на $db->sql
    sed -i ':a;N;$!ba;s/mysql_query(\n *"/$db->sql("/g' "inc/locations/merit.php"
    sed -i 's/mysql_query *("\([^"]*\)")/$db->sql("\1")/g' "inc/locations/merit.php"
    echo "Fixed: inc/locations/merit.php"
fi

# gameplay/sql_dump.php - сложные случаи
if [ -f "gameplay/sql_dump.php" ]; then
    sed -i 's/mysql_num_rows *(\([^)]*\))/$db->affected_rows()/g' "gameplay/sql_dump.php"
    sed -i 's/mysql_escape_string *(\([^)]*\))/$db->real_escape_string(\1)/g' "gameplay/sql_dump.php"
    sed -i 's/mysql_get_server_info()/$db->mysqli->server_info/g' "gameplay/sql_dump.php"
    sed -i 's/mysql_select_db *(\([^,]*\), *\([^)]*\))/$db->mysqli->select_db(\1)/g' "gameplay/sql_dump.php"
    echo "Fixed: gameplay/sql_dump.php"
fi

# gameplay/info/self.php
if [ -f "gameplay/info/self.php" ]; then
    sed -i 's/mysql_fetch_assoc *(\([^)]*\))/$db->fetchAssoc(\1)/g' "gameplay/info/self.php"
    echo "Fixed: gameplay/info/self.php"
fi

# auto.php
if [ -f "auto.php" ]; then
    sed -i 's/mysql_query *(\([^)]*\))/$db->sql(\1)/g' "auto.php"
    echo "Fixed: auto.php"
fi

# test_file.php
if [ -f "test_file.php" ]; then
    sed -i 's/mysql_query *(\([^)]*\))/$db->sql(\1)/g' "test_file.php"
    echo "Fixed: test_file.php"
fi

echo "All final fixes applied!"
