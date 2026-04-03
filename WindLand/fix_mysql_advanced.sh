#!/bin/bash
# Продвинутый скрипт для замены оставшихся mysql_* функций

cd /workspace/WindLand

# Обработка inc/locations/obelisk.php - замена сложных случаев с вложенными вызовами
if [ -f "inc/locations/obelisk.php" ]; then
    echo "Processing: inc/locations/obelisk.php"
    
    # Замена паттернов вида mysql_fetch_array(mysql_query(...))
    sed -i 's/mysql_fetch_array *( *mysql_query *(\([^)]*\) *) *)/$db->fetchArray($db->sql(\1))/g' "inc/locations/obelisk.php"
    
    # Замена оставшихся mysql_fetch_array
    sed -i 's/mysql_fetch_array *(\([^)]*\))/$db->fetchArray(\1)/g' "inc/locations/obelisk.php"
    
    # Замена оставшихся mysql_query
    sed -i 's/mysql_query *(\([^)]*\))/$db->sql(\1)/g' "inc/locations/obelisk.php"
    
    echo "  Done: inc/locations/obelisk.php"
fi

# Обработка inc/locations/lavka.php
if [ -f "inc/locations/lavka.php" ]; then
    echo "Processing: inc/locations/lavka.php"
    sed -i 's/mysql_fetch_array *(\([^)]*\))/$db->fetchArray(\1)/g' "inc/locations/lavka.php"
    sed -i 's/mysql_query *(\([^)]*\))/$db->sql(\1)/g' "inc/locations/lavka.php"
    echo "  Done: inc/locations/lavka.php"
fi

# Обработка inc/locations/merit.php
if [ -f "inc/locations/merit.php" ]; then
    echo "Processing: inc/locations/merit.php"
    sed -i 's/mysql_query *(\([^)]*\))/$db->sql(\1)/g' "inc/locations/merit.php"
    # Удаление SET NAMES
    sed -i '/SET NAMES/d' "inc/locations/merit.php"
    sed -i '/mysql_select_db/d' "inc/locations/merit.php"
    echo "  Done: inc/locations/merit.php"
fi

# Обработка inc/locations/instant/dragons.php
if [ -f "inc/locations/instant/dragons.php" ]; then
    echo "Processing: inc/locations/instant/dragons.php"
    sed -i 's/mysql_num_rows *(\([^)]*\))/$db->affected_rows()/g' "inc/locations/instant/dragons.php"
    sed -i 's/mysql_query *(\([^)]*\))/$db->sql(\1)/g' "inc/locations/instant/dragons.php"
    sed -i 's/mysql_fetch_array *(\([^)]*\))/$db->fetchArray(\1)/g' "inc/locations/instant/dragons.php"
    echo "  Done: inc/locations/instant/dragons.php"
fi

echo "Advanced processing complete!"
