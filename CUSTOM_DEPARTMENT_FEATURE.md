# Custom Department Feature

## Overview

Added the ability to add custom department names when creating or editing subjects, providing flexibility when predefined departments don't exist yet.

---

## Features

### 1. **Dual-Mode Department Input**

Users can now choose between:

-   **Dropdown Mode**: Select from predefined departments (IT, CS, IS, Computer Science, etc.)
-   **Custom Input Mode**: Type in a custom department name

### 2. **Easy Toggle Between Modes**

-   Click the toggle button to switch between dropdown and custom input
-   Button text changes to indicate current mode:
    -   "➕ Add custom department" - Switch to custom input
    -   "📋 Choose from existing departments" - Switch back to dropdown

### 3. **Smart Auto-Detection (Edit Form)**

When editing a subject with a custom department name that's not in the predefined list:

-   Automatically switches to custom input mode
-   Pre-fills the custom department name
-   User can still switch back to dropdown if needed

---

## How It Works

### User Interface

#### Create Subject Form (`/subjects/create`)

```
Department *
┌─────────────────────────────────────┐
│ Select Department               ▼  │
├─────────────────────────────────────┤
│ IT                                  │
│ CS                                  │
│ IS                                  │
│ Computer Science                    │
│ Information Technology              │
│ Information Systems                 │
│ ➕ Add New Department               │
└─────────────────────────────────────┘

[➕ Add custom department]
```

**After clicking toggle or selecting "Add New Department":**

```
Department *
┌─────────────────────────────────────┐
│ Enter new department name           │
└─────────────────────────────────────┘

[📋 Choose from existing departments]
```

### Technical Implementation

#### 1. **Dual HTML Elements**

-   `#departmentSelect` - Dropdown for predefined departments
-   `#departmentCustomInput` - Text input for custom department
-   Only one is visible and active at a time

#### 2. **Dynamic Name Attribute Switching**

```javascript
// In Dropdown Mode:
departmentSelect.name = "department"(submitted);
departmentCustomInput.name = "department_custom"(ignored);

// In Custom Mode:
departmentSelect.name = "department_old"(ignored);
departmentCustomInput.name = "department"(submitted);
```

#### 3. **Validation Rules Updated**

**Before:**

```php
'department' => 'required|string|in:IT,CS,IS,Computer Science,Information Technology,Information Systems'
```

**After:**

```php
'department' => 'required|string|max:100'
```

This allows any department name up to 100 characters.

---

## Code Changes

### Files Modified

#### 1. **SubjectController.php**

```php
// store() method - Line ~67
'department' => 'required|string|max:100',  // Changed from 'in:...'

// update() method - Line ~103
'department' => 'required|string|max:100',  // Changed from 'in:...'
```

#### 2. **create.blade.php**

-   Added dual-mode department input (dropdown + text input)
-   Added toggle button
-   Added JavaScript for mode switching
-   Includes Font Awesome icons for better UX

#### 3. **edit.blade.php**

-   Same dual-mode department input
-   Auto-detects custom departments
-   Automatically switches to custom mode if needed
-   Pre-fills custom department value

---

## Usage Examples

### Example 1: Using Predefined Department

1. Navigate to "Create Subject"
2. Select "IT" from dropdown
3. Fill other fields and submit
4. ✅ Subject created with department "IT"

### Example 2: Adding Custom Department

1. Navigate to "Create Subject"
2. Click "➕ Add custom department"
3. Type "Engineering" in the text field
4. Fill other fields and submit
5. ✅ Subject created with department "Engineering"

### Example 3: Using Dropdown Shortcut

1. Navigate to "Create Subject"
2. Select "➕ Add New Department" from dropdown
3. Automatically switches to text input
4. Type "Business Administration"
5. Submit form
6. ✅ Subject created with custom department

### Example 4: Editing Custom Department

1. Edit a subject with department "Engineering"
2. Form automatically shows text input with "Engineering"
3. Can modify to "Civil Engineering"
4. Or click toggle to choose predefined department
5. ✅ Subject updated with new department

---

## Benefits

### 1. **Flexibility**

-   ✅ No need to modify code to add new departments
-   ✅ Supports any department structure
-   ✅ Future-proof for institutional changes

### 2. **User Convenience**

-   ✅ Quick selection from common departments
-   ✅ Easy custom input when needed
-   ✅ No page reload or admin intervention required

### 3. **Data Consistency**

-   ✅ Common departments standardized in dropdown
-   ✅ Custom departments stored in same format
-   ✅ Filters automatically include all departments

### 4. **Smart Behavior**

-   ✅ Auto-detects non-standard departments in edit form
-   ✅ Seamless switching between modes
-   ✅ Maintains form state during toggles

---

## Dynamic Filter Integration

The custom departments automatically appear in the filter dropdowns because:

```php
// In SubjectController index() method
$departments = Subject::select('department')
    ->distinct()
    ->orderBy('department')
    ->pluck('department');
```

This query fetches ALL unique departments from the database, including:

-   Predefined departments (IT, CS, IS, etc.)
-   Custom departments (Engineering, Business, etc.)

**Result:** Filter dropdowns dynamically update to show both predefined and custom departments! 🎉

---

## Validation & Security

### Input Validation

-   ✅ Required field (can't be empty)
-   ✅ Maximum 100 characters
-   ✅ String type enforced
-   ✅ HTML special characters escaped
-   ✅ SQL injection prevented by Laravel's query builder

### JavaScript Validation

-   ✅ Only one input active at a time
-   ✅ Required attribute dynamically switched
-   ✅ Form won't submit without department

---

## Testing Checklist

### Create Subject

-   [ ] Select predefined department from dropdown → Submit → Success
-   [ ] Click toggle button → Enter custom department → Submit → Success
-   [ ] Select "Add New Department" from dropdown → Enter custom → Submit → Success
-   [ ] Try submitting without department → Validation error
-   [ ] Try department with 100+ characters → Validation error
-   [ ] Check that custom department appears in filters on index page

### Edit Subject

-   [ ] Edit subject with predefined department → Shows dropdown
-   [ ] Edit subject with custom department → Shows text input
-   [ ] Toggle from custom to dropdown → Select predefined → Save → Success
-   [ ] Toggle from dropdown to custom → Enter new custom → Save → Success
-   [ ] Verify department changes saved correctly

### Filter Integration

-   [ ] Create subject with custom department "Engineering"
-   [ ] Go to subjects index page
-   [ ] Check department filter dropdown
-   [ ] Verify "Engineering" appears in the list
-   [ ] Filter by "Engineering" → Shows correct subject

---

## Future Enhancements (Optional)

### Possible Improvements

-   [ ] Department management page (add/edit/delete departments)
-   [ ] Department autocomplete suggestions
-   [ ] Department usage statistics
-   [ ] Bulk department rename feature
-   [ ] Department abbreviation mapping (e.g., "Info Tech" → "IT")
-   [ ] Department hierarchy (School → College → Department)
-   [ ] Import departments from CSV

---

## Notes

### Database Schema

The `subjects` table already supports this:

```sql
department VARCHAR(255)
```

No migration needed! The field can store any department name.

### Backward Compatibility

-   ✅ Existing subjects with predefined departments work normally
-   ✅ No data migration required
-   ✅ Old validation rules updated without breaking changes

### Performance

-   Minimal impact - just one additional query for distinct departments
-   JavaScript is lightweight and runs client-side
-   No AJAX calls needed

---

## Summary

✅ **Predefined departments** for quick selection  
✅ **Custom department input** for flexibility  
✅ **Easy toggle** between modes  
✅ **Smart auto-detection** in edit form  
✅ **Dynamic filters** include custom departments  
✅ **No code changes** needed to add departments in the future

This feature empowers users to manage their own department structure while maintaining consistency for common departments! 🎓
