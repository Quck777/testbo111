#!/bin/bash
# Финальная обработка оставшихся файлов

cd /workspace/WindLand

# inc/locations/dhouse.php
if [ -f "inc/locations/dhouse.php" ]; then
    sed -i 's/mysql_fetch_array *(\([^)]*\))/$db->fetchArray(\1)/g' "inc/locations/dhouse.php"
    echo "Fixed: inc/locations/dhouse.php"
fi

# inc/adm/weapons.php
if [ -f "inc/adm/weapons.php" ]; then
    sed -i 's/mysql_fetch_array *(\([^,]*\),MYSQL_ASSOC)/$db->fetchArray(\1, MYSQLI_ASSOC)/g' "inc/adm/weapons.php"
    sed -i 's/mysql_fetch_array *(\([^)]*\))/$db->fetchArray(\1)/g' "inc/adm/weapons.php"
    echo "Fixed: inc/adm/weapons.php"
fi

# inc/adm/clans.php
if [ -f "inc/adm/clans.php" ]; then
    sed -i 's/mysql_fetch_array *(\([^)]*\))/$db->fetchArray(\1)/g' "inc/adm/clans.php"
    echo "Fixed: inc/adm/clans.php"
fi

# gameplay/ajax/upload.php - требует отдельной обработки
if [ -f "gameplay/ajax/upload.php" ]; then
    # Заменяем mysql_connect на новый подход
    sed -i 's/mysql_connect *( *\(\$mysqlhost\|[^,]*\)* *, *\(\$mysqluser\|[^,]*\)* *, *\(\$mysqlpass\|[^,]*\) *)/new mysqli($mysqlhost, $mysqluser, $mysqlpass)/g' "gameplay/ajax/upload.php"
    echo "Fixed: gameplay/ajax/upload.php (partial)"
fi

# gameplay/ajax/lib_img_update.php
if [ -f "gameplay/ajax/lib_img_update.php" ]; then
    sed -i 's/mysql_connect *( *\(\$mysqlhost\|[^,]*\)* *, *\(\$mysqluser\|[^,]*\)* *, *\(\$mysqlpass\|[^,]*\)* *, *\(\$mysqlbase\|[^,]*\) *)/new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqlbase)/g' "gameplay/ajax/lib_img_update.php"
    echo "Fixed: gameplay/ajax/lib_img_update.php (partial)"
fi

# gameplay/ajax/img_list.php
if [ -f "gameplay/ajax/img_list.php" ]; then
    sed -i 's/mysql_connect *( *\(\$mysqlhost\|[^,]*\)* *, *\(\$mysqluser\|[^,]*\)* *, *\(\$mysqlpass\|[^,]*\)* *, *\(\$mysqlbase\|[^,]*\) *)/new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqlbase)/g' "gameplay/ajax/img_list.php"
    sed -i 's/mysql_close( *\([^)]*\) *)/if (\1 instanceof mysqli) \1->close()/g' "gameplay/ajax/img_list.php"
    echo "Fixed: gameplay/ajax/img_list.php (partial)"
fi

echo "Final fixes applied!"
