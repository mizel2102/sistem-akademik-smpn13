Summary of changes: BK counseling & warning letters work

Files changed:
- resources/views/admin/counselings/create.blade.php (UI + form components)
- resources/views/admin/counselings/index.blade.php (list + actions)
- resources/views/admin/warning-letters/create.blade.php (UI + form components)
- resources/views/admin/warning-letters/index.blade.php (list + actions + PDF download button)
- resources/views/admin/warning-letters/show.blade.php (detail view)
- resources/views/admin/warning-letters/pdf.blade.php (printable PDF, conditional logo + letterhead)
- app/Http/Controllers/Admin/WarningLetterController.php (added pdf() method)
- routes/web.php (added route admin.warning-letters.pdf)
- resources/views/dashboard.blade.php (quick actions for guru-bk)
- tests/Feature/AdminCrudTest.php (added BK create and PDF tests)
- resources/views/welcome-old.blade.php, resources/views/welcome-white.blade.php (guarded register link)
- temp_config_debug.php (removed)

What I fixed / mitigated:
- Prevented DomPDF crash when PHP GD is missing by rendering logo only if GD is available.
- Removed leftover temp debug script that attempted internal HTTP calls causing 500 errors.
- Guarded `route('register')` in public landing views to avoid errors when the route is not defined.
- Added PDF download link in SP index and implemented controller + view for PDF export.
- Added tests and ensured the full test suite passes locally under the repo's test runner (`vendor/bin/pest`).

Commands to commit locally (run in project root):

```bash
# create a branch (optional)
git checkout -b feature/bk-warning-letters

# stage and commit
git add -A
git commit -m "feat(bk): counseling & warning letters UI, PDF export, and tests"

# push to remote (optional)
git push -u origin feature/bk-warning-letters
```

If you want, I can also prepare a single patch file with the diffs for you to apply manually. Let me know which you prefer.
