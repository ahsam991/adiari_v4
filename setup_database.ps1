$mysql = "C:\xampp\mysql\bin\mysql.exe"
$user = "root"
$password = "" # Empty for XAMPP default

function Run-Query {
    param([string]$query)
    Write-Host "Executing: $query"
    & $mysql -u $user -e "$query"
}

function Run-File {
    param([string]$db, [string]$file)
    Write-Host "Importing $file into $db"
    # Using cmd /c type to handle encoding and piping reliably
    cmd /c "type `"$file`" | `"$mysql`" -u $user $db"
}

Write-Host "Creating databases..."
Run-Query "DROP DATABASE IF EXISTS adiari_grocery;"
Run-Query "CREATE DATABASE adiari_grocery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
Run-Query "DROP DATABASE IF EXISTS adiari_inventory;"
Run-Query "CREATE DATABASE adiari_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
Run-Query "DROP DATABASE IF EXISTS adiari_analytics;"
Run-Query "CREATE DATABASE adiari_analytics CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

Write-Host "Running migrations..."
$migrations = Get-ChildItem "database\migrations\*.sql" | Sort-Object Name

foreach ($file in $migrations) {
    $filename = $file.Name
    $num = [int]($filename.Substring(0, 3))
    
    if ($num -ge 1 -and $num -le 12) {
        Run-File "adiari_grocery" $file.FullName
    } elseif ($num -ge 13 -and $num -le 15) {
        Run-File "adiari_inventory" $file.FullName
    } elseif ($num -ge 16 -and $num -le 18) {
        Run-File "adiari_analytics" $file.FullName
    }
}

Write-Host "Running seeds..."
$seeds = Get-ChildItem "database\seeds\*.sql" | Sort-Object Name
foreach ($file in $seeds) {
    # Seeder has USE statements, so initial DB doesn't strictly matter, 
    # but connecting to grocery is safe default.
    Run-File "adiari_grocery" $file.FullName
}

Write-Host "Database setup complete!"
