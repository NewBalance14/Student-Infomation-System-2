# Search & Filter Improvements

## Overview

Fixed the search and filter functionality for both **Subjects** and **Students** pages. Previously, filters were static (hardcoded) and search didn't work. Now everything is dynamic and pulls data directly from the database.

---

## Changes Made

### 1. **Subject Controller** (`app/Http/Controllers/Admin/SubjectController.php`)

#### Before:

```php
public function index()
{
    $subjects = Subject::latest()->paginate(10);
    return view('subjects.index', compact('subjects'));
}
```

#### After:

```php
public function index(Request $request)
{
    $query = Subject::query();

    // Search functionality (code or name)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('code', 'LIKE', "%{$search}%")
              ->orWhere('name', 'LIKE', "%{$search}%");
        });
    }

    // Filter by department
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    // Filter by year level
    if ($request->filled('year_level')) {
        $query->where('year_level', $request->year_level);
    }

    // Filter by semester
    if ($request->filled('semester')) {
        $query->where('semester', $request->semester);
    }

    $subjects = $query->latest()->paginate(10)->withQueryString();

    // Get distinct values for filters (dynamic dropdowns)
    $departments = Subject::distinct()->pluck('department')->filter();
    $yearLevels = Subject::distinct()->pluck('year_level')->filter()->sort();

    return view('subjects.index', compact('subjects', 'departments', 'yearLevels'));
}
```

**Key Features:**

-   ✅ Search by subject code or name
-   ✅ Filter by department (dynamic from database)
-   ✅ Filter by year level (dynamic from database)
-   ✅ Filter by semester
-   ✅ Pagination preserves filters with `withQueryString()`
-   ✅ Filters only show options that exist in the database

---

### 2. **Student Controller** (`app/Http/Controllers/StudentController.php`)

#### Before:

```php
public function index()
{
    $students = Student::with('user')->latest()->paginate(10);
    return view('students.index', compact('students'));
}
```

#### After:

```php
public function index(Request $request)
{
    $query = Student::with('user');

    // Search functionality (student number or name)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('student_number', 'LIKE', "%{$search}%")
              ->orWhereHas('user', function($subQuery) use ($search) {
                  $subQuery->where('name', 'LIKE', "%{$search}%");
              });
        });
    }

    // Filter by department
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    // Filter by year level
    if ($request->filled('year_level')) {
        $query->where('year_level', $request->year_level);
    }

    // Filter by semester
    if ($request->filled('semester')) {
        $query->where('semester', $request->semester);
    }

    // Filter by verification status
    if ($request->filled('verification_status')) {
        if ($request->verification_status === 'verified') {
            $query->whereHas('user', function($q) {
                $q->where('is_verified', true);
            });
        } elseif ($request->verification_status === 'pending') {
            $query->whereHas('user', function($q) {
                $q->where('is_verified', false);
            });
        }
    }

    $students = $query->latest()->paginate(10)->withQueryString();

    // Get distinct values for filters (dynamic dropdowns)
    $departments = Student::distinct()->pluck('department')->filter();
    $yearLevels = Student::distinct()->pluck('year_level')->filter()->sort();
    $semesters = Student::distinct()->pluck('semester')->filter()->sort();

    return view('students.index', compact('students', 'departments', 'yearLevels', 'semesters'));
}
```

**Key Features:**

-   ✅ Search by student number or student name
-   ✅ Filter by department (dynamic from database)
-   ✅ Filter by year level (dynamic from database)
-   ✅ Filter by semester (dynamic from database)
-   ✅ Filter by verification status (verified/pending)
-   ✅ Pagination preserves filters
-   ✅ Uses relationship queries to search user names

---

### 3. **Subjects View** (`resources/views/subjects/index.blade.php`)

#### Changes:

-   ✅ **Dynamic filter dropdowns** - Replaced hardcoded options with `@foreach` loops:

    ```php
    <!-- Before -->
    <option value="Computer Science">Computer Science</option>
    <option value="Information Technology">Information Technology</option>

    <!-- After -->
    @foreach($departments as $dept)
        <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
            {{ $dept }}
        </option>
    @endforeach
    ```

-   ✅ **Results count display**:

    ```php
    @if($subjects->total() > 0)
        <div class="mb-3 text-sm text-gray-600">
            Showing {{ $subjects->firstItem() }} to {{ $subjects->lastItem() }} of {{ $subjects->total() }} results
            @if(request()->hasAny(['search', 'department', 'year_level', 'semester']))
                <span class="fw-bold">(filtered)</span>
            @endif
        </div>
    @endif
    ```

-   ✅ **Enhanced "No results" message**:
    ```php
    @empty
        <tr>
            <td colspan="7" class="text-center py-4">
                <div class="text-gray-500">
                    <i class="fas fa-search mb-2" style="font-size: 2rem;"></i>
                    <p class="mb-1 fw-bold">No subjects found</p>
                    @if(request()->hasAny(['search', 'department', 'year_level', 'semester']))
                        <p class="mb-0 small">Try adjusting your filters or search criteria</p>
                    @else
                        <p class="mb-0 small">No subjects have been added yet</p>
                    @endif
                </div>
            </td>
        </tr>
    @endforelse
    ```

---

### 4. **Students View** (`resources/views/students/index.blade.php`)

#### Changes:

-   ✅ **Dynamic filter dropdowns** for departments, year levels, and semesters
-   ✅ **Results count display** with filter indicator
-   ✅ **Enhanced "No results" message** with contextual text
-   ✅ **Verification status filter** preserved in URL parameters

---

## Testing Checklist

### Subjects Page

-   [ ] Search by subject code works
-   [ ] Search by subject name works
-   [ ] Department filter shows only departments in database
-   [ ] Year level filter shows only year levels in database
-   [ ] Semester filter works (1st/2nd Semester)
-   [ ] Multiple filters work together
-   [ ] Pagination preserves filter parameters
-   [ ] Results count displays correctly
-   [ ] "No results" message shows when filters return empty

### Students Page

-   [ ] Search by student number works
-   [ ] Search by student name works
-   [ ] Department filter shows only departments in database
-   [ ] Year level filter shows only year levels in database
-   [ ] Semester filter shows only semesters in database
-   [ ] Verification status filter works (Verified/Pending)
-   [ ] Multiple filters work together
-   [ ] Pagination preserves filter parameters
-   [ ] Results count displays correctly
-   [ ] "No results" message shows when filters return empty

---

## Benefits

### 1. **Dynamic Data**

-   Filters automatically update based on actual database content
-   No hardcoded values that might be outdated
-   Prevents showing filter options that don't exist in the database

### 2. **Better UX**

-   Results count shows users what they're viewing
-   Clear indication when filters are active
-   Helpful messages when no results are found
-   Filter state preserved across pagination

### 3. **Performance**

-   Efficient database queries with `distinct()` and `pluck()`
-   Pagination reduces memory usage
-   Query builder only fetches needed columns for filters

### 4. **Maintainability**

-   No need to update views when database content changes
-   Single source of truth (the database)
-   Easy to add more filter options in the future

---

## How to Use

### For Subjects:

1. Navigate to `/subjects`
2. Use the search box to find subjects by code or name
3. Use department dropdown to filter by department
4. Use year level dropdown to filter by year
5. Use semester dropdown to filter by semester
6. Click "Search" to apply filters
7. Click "Clear" to reset all filters

### For Students:

1. Navigate to `/students`
2. Use the search box to find students by student number or name
3. Use department dropdown to filter by department
4. Use year level dropdown to filter by year
5. Use semester dropdown to filter by semester
6. Use verification status dropdown to filter by verified/pending students
7. Click "Search" to apply filters
8. Click "Clear" to reset all filters

---

## Technical Notes

-   All filters use `GET` method for bookmarkable URLs
-   Filter parameters are preserved in pagination links
-   Search uses `LIKE` queries for partial matching
-   Dropdowns only show non-null values from database
-   Year levels are sorted numerically
-   Controllers validate input through Laravel's request object

---

## Future Enhancements (Optional)

-   [ ] Add AJAX filtering (no page reload)
-   [ ] Add date range filters
-   [ ] Add sorting options (by name, date, etc.)
-   [ ] Add export filtered results to CSV/PDF
-   [ ] Add saved filter presets
-   [ ] Add filter count badges
-   [ ] Add "Recently Used" filters
