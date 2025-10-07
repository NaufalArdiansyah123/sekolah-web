-- =====================================================
-- SIMPLE STATUS COLUMN FIX
-- Copy and paste this SQL into phpMyAdmin
-- =====================================================

-- Step 1: Check current status column (optional)
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'sekolah-web6'
AND TABLE_NAME = 'facilities' 
AND COLUMN_NAME = 'status';

-- Step 2: Drop the problematic status column
ALTER TABLE facilities DROP COLUMN IF EXISTS status;

-- Step 3: Add correct ENUM status column
ALTER TABLE facilities ADD COLUMN status ENUM('active', 'maintenance', 'inactive') DEFAULT 'active';

-- Step 4: Update all existing facilities to have 'active' status
UPDATE facilities SET status = 'active' WHERE status IS NULL OR status = '';

-- Step 5: Verify the fix
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'sekolah-web6'
AND TABLE_NAME = 'facilities' 
AND COLUMN_NAME = 'status';

-- Step 6: Check facilities by status
SELECT status, COUNT(*) as count FROM facilities GROUP BY status;

-- Step 7: Test insert (optional)
-- INSERT INTO facilities (name, description, category, status, created_at, updated_at) 
-- VALUES ('Test Facility', 'Test Description', 'other', 'active', NOW(), NOW());

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================

-- Show table structure
DESCRIBE facilities;

-- Show all facilities with their status
SELECT id, name, status FROM facilities LIMIT 10;

-- Count facilities by status
SELECT 
    status,
    COUNT(*) as total,
    CONCAT(ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM facilities)), 1), '%') as percentage
FROM facilities 
GROUP BY status;

-- =====================================================
-- SUCCESS MESSAGE
-- =====================================================
-- If all queries run without errors, your status column is fixed!
-- You can now create facilities without the data truncation error.