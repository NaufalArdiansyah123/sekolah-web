-- =====================================================
-- URGENT FIX: Facilities Status Column Data Truncation
-- =====================================================
-- Run this SQL script to fix the status column issue

-- Step 1: Check current status column structure
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'facilities' 
AND COLUMN_NAME = 'status';

-- Step 2: Backup existing data (optional - for safety)
-- CREATE TABLE facilities_backup AS SELECT * FROM facilities;

-- Step 3: Fix the status column
-- First, drop the problematic status column
ALTER TABLE facilities DROP COLUMN status;

-- Then, add the correct ENUM column
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
WHERE TABLE_NAME = 'facilities' 
AND COLUMN_NAME = 'status';

-- Step 6: Test insert (you can run this to test)
-- INSERT INTO facilities (name, description, category, status, created_at, updated_at) 
-- VALUES ('Test Facility', 'Test Description', 'other', 'active', NOW(), NOW());

-- Step 7: Check facilities by status
SELECT status, COUNT(*) as count FROM facilities GROUP BY status;

-- =====================================================
-- ALTERNATIVE METHOD (if above doesn't work)
-- =====================================================

-- Method 2: Modify existing column directly
-- ALTER TABLE facilities MODIFY COLUMN status ENUM('active', 'maintenance', 'inactive') DEFAULT 'active';

-- Method 3: If you need to preserve existing data with different status values
-- UPDATE facilities SET status = 'active' WHERE status NOT IN ('active', 'maintenance', 'inactive');

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================

-- Check table structure
DESCRIBE facilities;

-- Check all facilities
SELECT id, name, status FROM facilities LIMIT 10;

-- Count by status
SELECT status, COUNT(*) FROM facilities GROUP BY status;