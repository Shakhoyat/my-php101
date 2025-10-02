# 📞 Simple Contact Management System

## 🗂️ New Folder Structure

```
form-superglobal/
├── database/                 ← All database files here
│   ├── config.php           ← Database settings
│   ├── setup.php            ← Creates database & table
│   └── functions.php        ← Simple database functions
├── uploads/                 ← Contact photos
├── index.php                ← Main page (view contacts)
├── add.php                  ← Add new contact
└── delete.php               ← Delete contact
```

## 🚀 How to Use

### 1. Setup Database (First Time Only)
Visit: `http://localhost:8000/form-superglobal/database/setup.php`

### 2. Use the App
Visit: `http://localhost:8000/form-superglobal/index.php`

## 📝 What Each File Does

### `database/config.php` - Simple Settings
```php
define('DB_HOST', 'localhost');    // Where database is
define('DB_USER', 'root');         // Database username  
define('DB_PASS', '');             // Database password
define('DB_NAME', 'contacts_db');  // Database name
```

### `database/functions.php` - Simple Functions
- `getAllContacts()` - Get all contacts
- `addContact()` - Add new contact
- `deleteContact()` - Remove contact
- `emailExists()` - Check if email already used

### Main Files
- **`index.php`** - Shows all contacts
- **`add.php`** - Form to add new contact  
- **`delete.php`** - Removes contact

## 🎓 Learning Benefits

✅ **Organized** - Database code separated  
✅ **Simple** - Short, easy-to-read functions  
✅ **Secure** - Uses prepared statements  
✅ **Clean** - No complex code for beginners  

## 🔧 Database Table Structure

```sql
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 💡 Next Steps to Learn

1. **Add Edit Feature** - Update existing contacts
2. **Add Search** - Find contacts by name
3. **Add Categories** - Family, Work, Friends
4. **Add Validation** - Better form checking

---

**Perfect for beginners! Simple, clean, and easy to understand! 🎉**