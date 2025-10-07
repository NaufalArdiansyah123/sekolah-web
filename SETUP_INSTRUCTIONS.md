# 🚀 Study Programs Setup Instructions

## Quick Setup (Recommended)

Run the complete setup script:

```bash
php complete_setup.php
```

This will automatically:
- ✅ Create database table
- ✅ Create storage directories  
- ✅ Create storage link
- ✅ Add sample data
- ✅ Clear cache

## Manual Setup (Alternative)

If you prefer to run each step manually:

### 1. Run Migration
```bash
php run_migration.php
```

### 2. Run Seeder
```bash
php run_seeder.php
```

### 3. Clear Cache
```bash
php clear_cache.php
```

### 4. Check Status
```bash
php check_database.php
```

## Access URLs

After setup is complete:

- **Admin Panel**: `/admin/study-programs`
- **Public Page**: `/study-programs`

## Features Available

### Admin Panel
- ✅ Create/Edit/Delete study programs
- ✅ Upload program images and brochures
- ✅ Manage program status (active/inactive)
- ✅ Feature programs for highlighting
- ✅ Dynamic form sections for subjects, specializations, facilities
- ✅ Search and filtering
- ✅ Statistics dashboard

### Public Pages
- ✅ Browse all active programs
- ✅ Filter by degree level and faculty
- ✅ Search programs
- ✅ View detailed program information
- ✅ Download brochures
- ✅ Featured programs section

## Troubleshooting

If you encounter issues:

1. **Permission Errors**:
   ```bash
   chmod -R 755 storage/
   ```

2. **Database Connection**:
   - Check your `.env` file
   - Ensure database exists

3. **Routes Not Working**:
   ```bash
   php artisan route:cache
   ```

4. **Views Not Loading**:
   ```bash
   php artisan view:cache
   ```

## File Structure Created

```
database/
├── migrations/2024_01_15_000000_create_study_programs_table.php
├── seeders/StudyProgramSeeder.php
└── factories/StudyProgramFactory.php

app/
├── Models/StudyProgram.php
├── Http/Controllers/Admin/StudyProgramController.php
├── Http/Controllers/StudyProgramController.php
└── Http/Requests/StudyProgramRequest.php

resources/views/
├── admin/study-programs/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── study-programs/
    ├── index.blade.php
    ├── show.blade.php
    └── partials/program-card.blade.php

storage/app/public/
└── study-programs/
    ├── images/
    └── brochures/
```

## Next Steps

1. Test the system by creating a new study program
2. Upload some sample images and brochures
3. Configure any additional settings
4. Customize the design if needed

Happy coding! 🎉