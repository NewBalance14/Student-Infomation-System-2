# Custom Department Feature - Quick Guide

## 🎯 What This Feature Does

Allows you to **add custom department names** when creating or editing subjects without needing to modify code!

---

## 📋 How to Use

### Method 1: Click the Toggle Button

**Step 1:** Start creating a subject  
**Step 2:** Look for the department field  
**Step 3:** Click the button below: **"➕ Add custom department"**  
**Step 4:** Type your custom department name (e.g., "Engineering", "Business Administration")  
**Step 5:** Submit the form

### Method 2: Select from Dropdown

**Step 1:** Start creating a subject  
**Step 2:** Click the department dropdown  
**Step 3:** Select **"➕ Add New Department"** from the bottom of the list  
**Step 4:** The form automatically switches to custom input  
**Step 5:** Type your department name  
**Step 6:** Submit the form

### Switching Back to Predefined

**Step 1:** In custom input mode  
**Step 2:** Click **"📋 Choose from existing departments"**  
**Step 3:** Select from the predefined list (IT, CS, IS, etc.)  
**Step 4:** Submit the form

---

## ✨ Features

### ✅ Two Modes

#### **Dropdown Mode** (Default)

```
Department *
┌──────────────────────────┐
│ Select Department     ▼  │
└──────────────────────────┘
• IT
• CS
• IS
• Computer Science
• Information Technology
• Information Systems
• ➕ Add New Department
```

#### **Custom Input Mode**

```
Department *
┌──────────────────────────┐
│ Enter new department...  │
└──────────────────────────┘
```

### ✅ Smart Edit Form

When you edit a subject with a **custom department** (like "Engineering"):

-   The form **automatically switches** to custom input mode
-   Your custom department name is **pre-filled**
-   You can still switch back to dropdown if needed

---

## 🔍 Examples

### Example 1: Create Subject with "Nursing"

```
1. Go to "Create Subject"
2. Click "➕ Add custom department"
3. Type: "Nursing"
4. Fill other fields (code, name, etc.)
5. Click "Create Subject"

✅ Result: Subject created with department "Nursing"
```

### Example 2: Edit IT to Engineering

```
1. Edit a subject with department "IT"
2. Click "➕ Add custom department"
3. Type: "Engineering"
4. Click "Update Subject"

✅ Result: Department changed from "IT" to "Engineering"
```

### Example 3: Change Custom to Predefined

```
1. Edit a subject with department "Business"
2. (Form shows custom input automatically)
3. Click "📋 Choose from existing departments"
4. Select "IT" from dropdown
5. Click "Update Subject"

✅ Result: Department changed from "Business" to "IT"
```

---

## 💡 Tips

### Tip 1: Filters Update Automatically

After adding a custom department like "Engineering":

-   Go to the subjects list page
-   Open the department filter dropdown
-   **"Engineering" will appear** in the list automatically!

### Tip 2: Consistent Naming

Use consistent names to avoid duplicates:

-   ✅ Good: "Engineering", "Engineering", "Engineering"
-   ❌ Bad: "Engineering", "Engr", "ENGINEERING", "Eng"

### Tip 3: Use Descriptive Names

-   ✅ Good: "Computer Science", "Information Technology"
-   ⚠️ Okay: "CS", "IT"
-   ❌ Too vague: "Dept A", "Other"

### Tip 4: Character Limit

-   Maximum **100 characters** for department names
-   Most department names are 20-40 characters

---

## 🎨 Visual Guide

### Before (Dropdown):

```
╔════════════════════════════════╗
║ Department *                   ║
║ ┌────────────────────────┐     ║
║ │ Select Department   ▼  │     ║
║ └────────────────────────┘     ║
║                                ║
║ [➕ Add custom department]     ║
╚════════════════════════════════╝
```

### After Toggle (Custom Input):

```
╔════════════════════════════════╗
║ Department *                   ║
║ ┌────────────────────────┐     ║
║ │ Engineering            │     ║
║ └────────────────────────┘     ║
║                                ║
║ [📋 Choose from existing]      ║
╚════════════════════════════════╝
```

---

## ⚠️ Important Notes

### Validation

-   Department field is **required** (can't be empty)
-   Maximum **100 characters**
-   Can contain letters, numbers, spaces, and special characters

### Database

-   All departments (predefined and custom) are stored the same way
-   No difference in how the system treats them
-   Custom departments appear everywhere regular departments do

### Filters

-   Custom departments **automatically appear** in filter dropdowns
-   No need to refresh or reload
-   Work exactly like predefined departments

---

## 🚀 Quick Start

**Want to try it now?**

1. Go to: `/subjects/create`
2. Look for the "Department" field
3. Click: **"➕ Add custom department"**
4. Type: **"Your Custom Department"**
5. Fill other required fields
6. Submit!

**That's it!** Your custom department is now in the system and will appear in filters. 🎉

---

## 🆘 Troubleshooting

### Problem: Button doesn't appear

**Solution:** Make sure JavaScript is enabled in your browser

### Problem: Can't switch between modes

**Solution:** Refresh the page and try again

### Problem: Custom department not saving

**Solution:** Make sure you filled all required fields (code, name, units, etc.)

### Problem: Custom department not in filters

**Solution:** The department will appear after you create at least one subject with it

---

## 📚 Related Documentation

-   `SUBJECT_CRUD_FIX.md` - Fix for add subject functionality
-   `SEARCH_FILTER_IMPROVEMENTS.md` - Search and filter features
-   `CUSTOM_DEPARTMENT_FEATURE.md` - Detailed technical documentation

---

**Need help?** Check the full documentation in `CUSTOM_DEPARTMENT_FEATURE.md`
