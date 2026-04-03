#!/bin/bash
# Скрипт для замены устаревших mysql_* функций на mysqli через класс MySQL

cd /workspace/WindLand

# Файлы для обработки
files=(
    "inc/func.php"
    "inc/inc/fights/finish.php"
    "inc/inc/magic.php"
    "inc/inc/characters/pochta.php"
    "inc/inc/wears.php"
    "inc/class/reg.class.php"
    "inc/locations/dhouse/create.php"
    "inc/locations/obelisk.php"
    "inc/locations/merry.php"
    "inc/locations/merit.php"
    "inc/locations/dhouse.php"
    "inc/locations/lavka.php"
    "inc/locations/instant/dragons.php"
    "inc/adm/clans.php"
    "inc/adm/weapons.php"
    "auto.php"
    "frames/ch.php"
    "gameplay/ajax/img_list.php"
    "gameplay/ajax/lib_img_update.php"
    "gameplay/ajax/upload.php"
    "gameplay/info/self.php"
    "gameplay/sql_dump.php"
    "test_file.php"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "Processing: $file"
        
        # Замена mysql_query на $db->sql
        sed -i 's/mysql_query(\([^)]*\))/$db->sql(\1)/g' "$file"
        
        # Замена mysql_fetch_array на $db->fetchArray
        sed -i 's/mysql_fetch_array(\([^)]*\))/$db->fetchArray(\1)/g' "$file"
        
        # Замена mysql_fetch_assoc на $db->fetchAssoc
        sed -i 's/mysql_fetch_assoc(\([^)]*\))/$db->fetchAssoc(\1)/g' "$file"
        
        # Замена mysql_fetch_row на $db->fetchRow
        sed -i 's/mysql_fetch_row(\([^)]*\))/$db->fetchRow(\1)/g' "$file"
        
        # Замена mysql_result на $db->result
        sed -i 's/mysql_result(\([^,]*\),\([^,]*\),\([^)]*\))/$db->result(\1,\3,\2)/g' "$file"
        sed -i 's/mysql_result(\([^,]*\),\([^)]*\))/$db->result(\1,\2)/g' "$file"
        
        # Замена mysql_affected_rows на $db->affected_rows()
        sed -i 's/mysql_affected_rows()/$db->affected_rows()/g' "$file"
        
        # Замена mysql_real_escape_string на $db->real_escape_string
        sed -i 's/mysql_real_escape_string(\([^)]*\))/$db->real_escape_string(\1)/g' "$file"
        
        # Замена mysql_free_result на ->free()
        sed -i 's/mysql_free_result(\([^)]*\))/if (\1 instanceof mysqli_result) \1->free()/g' "$file"
        
        # Замена mysql_insert_id на $db->insert_id()
        sed -i 's/mysql_insert_id()/$db->insert_id()/g' "$file"
        
        # Замена mysql_select_db
        sed -i 's/mysql_select_db(\([^,]*\),\([^)]*\))/$db->mysqli->select_db(\1)/g' "$file"
        
        # Замена mysql_error на $db->mysqli->error
        sed -i 's/mysql_error()/$db->mysqli->error/g' "$file"
        
        # Удаление устаревших SET NAMES (кодировка устанавливается в классе MySQL)
        sed -i '/mysql_query.*SET NAMES/d' "$file"
        sed -i '/mysql_query.*SET NAMES/d' "$file"
        
        echo "  Done: $file"
    fi
done

echo "All files processed!"
