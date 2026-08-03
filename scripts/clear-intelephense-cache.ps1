# Clear Intelephense cache folders under the current workspace
# Usage: Open PowerShell in project root and run: .\scripts\clear-intelephense-cache.ps1

Write-Host "Scanning for .intelephense cache folders under: $(Get-Location)" -ForegroundColor Cyan
$folders = Get-ChildItem -Path . -Recurse -Force -Directory -ErrorAction SilentlyContinue | Where-Object { $_.Name -ieq '.intelephense' }
if (-not $folders) {
    Write-Host "No .intelephense folders found in this workspace." -ForegroundColor Yellow
    exit 0
}

Write-Host "Found the following .intelephense folders:" -ForegroundColor Green
$folders | ForEach-Object { Write-Host $_.FullName }

$confirm = Read-Host "Delete these folders and their contents? (y/N)"
if ($confirm -ne 'y' -and $confirm -ne 'Y') {
    Write-Host 'Aborted by user.' -ForegroundColor Yellow
    exit 0
}

foreach ($f in $folders) {
    try {
        Remove-Item -LiteralPath $f.FullName -Recurse -Force -ErrorAction Stop
        Write-Host "Deleted: $($f.FullName)" -ForegroundColor Green
    } catch {
        Write-Host "Failed to delete: $($f.FullName) — $_" -ForegroundColor Red
    }
}

Write-Host "Done. Reload VS Code window or run 'code -r .' to refresh the editor." -ForegroundColor Cyan
