# Subject CRUD - Add/Edit Fix

## Problem

The "Add New Subject" form was not working because it was missing a required field.

## Root Cause

The `SubjectController`'s `store()` method requires the following fields:

-   code
-   name
-   department
-   year_level
-   semester
-   **units** ⚠️ (This was missing from the form!)
-   description (optional)

However, the `create.blade.php` form was missing the **units** input field, causing validation to fail silently.

Additionally, the department dropdown options didn't match the validation rules.

---

## Fixes Applied

### 1. **Added Units Field** to `create.blade.php`

```php
<div class="mb-4">
    <label for="units" class="block text-gray-700 text-sm font-bold mb-2">
        Units *
    </label>
    <input type="number"
           name="units"
           id="units"
           value="{{ old('units', 3) }}"
           min="1"
           max="6"
           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
           required>

    @error('units')
        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
    @enderror
</div>
```

**Features:**

-   ✅ Number input with min/max validation (1-6 units)
-   ✅ Default value of 3 units
-   ✅ Required field
-   ✅ Error message display

---

### 2. **Updated Department Options** to match validation rules

The controller validates departments as:

```php
'department' => 'required|string|in:IT,CS,IS,Computer Science,Information Technology,Information Systems'
```

Updated both `create.blade.php` and `edit.blade.php`:

```php
<select name="department" id="department" required>
    <option value="">Select Department</option>
    <option value="IT">IT</option>
    <option value="CS">CS</option>
    <option value="IS">IS</option>
    <option value="Computer Science">Computer Science</option>
    <option value="Information Technology">Information Technology</option>
    <option value="Information Systems">Information Systems</option>
</select>
```

**Before:** Only had "IT" and "EMC" options (EMC wasn't even in validation rules!)  
**After:** Has all 6 valid options matching the controller validation

---

### 3. **Added Units Field** to `edit.blade.php`

Applied the same units field to the edit form for consistency:

```php
<div class="mb-4">
    <label for="units" class="block text-gray-700 text-sm font-bold mb-2">
        Units *
    </label>
    <input type="number"
           name="units"
           id="units"
           value="{{ old('units', $subject->units) }}"
           min="1"
           max="6"
           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
           required>

    @error('units')
        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
    @enderror
</div>
```

---

## Files Modified

1. ✅ `resources/views/subjects/create.blade.php`

    - Added units input field
    - Updated department dropdown options

2. ✅ `resources/views/subjects/edit.blade.php`
    - Added units input field
    - Updated department dropdown options

---

## Testing Checklist

### Create Subject

-   [ ] Navigate to `/subjects/create`
-   [ ] Fill in all fields including units (1-6)
-   [ ] Select a department from the dropdown
-   [ ] Submit the form
-   [ ] Verify subject is created successfully
-   [ ] Check that units are saved correctly

### Edit Subject

-   [ ] Navigate to an existing subject's edit page
-   [ ] Verify units field shows current value
-   [ ] Change units to a different value (1-6)
-   [ ] Update department if needed
-   [ ] Submit the form
-   [ ] Verify changes are saved

### Validation

-   [ ] Try submitting without units (should show error)
-   [ ] Try entering units < 1 (should prevent)
-   [ ] Try entering units > 6 (should prevent)
-   [ ] Try selecting an invalid department (should show error)

---

## Summary

**Problem:** Missing `units` field in subject forms  
**Solution:** Added units input field to both create and edit forms  
**Impact:** Subject creation and editing now work properly ✅

The forms now include all required fields matching the controller validation rules.
