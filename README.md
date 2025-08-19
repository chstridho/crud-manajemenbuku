# 📚 Book Management System - CRUD Application  

**A simple PHP-based CRUD application for managing book collections.**  

🔗 **GitHub Repository:** [https://github.com/chstridho/crud-manajemenbuku](https://github.com/chstridho/crud-manajemenbuku)  

---

## 🚀 Overview  
This project is a complete **Book Management System** that allows users to perform basic CRUD operations (Create, Read, Update, Delete) on book records. Built with core PHP and MySQL, it demonstrates fundamental web development concepts including database interactions, form handling, and server-side processing.

---

## ⚙️ Features  
- **Create Book Records**: Add new books with title, author, publisher, and year  
- **Read/View Books**: Display all books in a clean table format  
- **Update Records**: Modify existing book information  
- **Delete Records**: Remove books from the database  
- **Search Functionality**: Filter books by title or author  
- **Responsive Design**: Works on all device sizes  

---

## 🛠️ Tech Stack  
- **Frontend**: HTML5, CSS3  
- **Backend**: PHP  
- **Database**: MySQL  
- **Server**: Apache (XAMPP/WAMPP compatible)  

---

## 📂 Project Structure  
```bash
crud-manajemenbuku/
├── index.php         # Main page (displays books)
├── tambah.php        # Add new book form
├── edit.php          # Edit existing book form
├── hapus.php         # Delete book handler
├── koneksi.php       # Database connection setup
├── style.css         # Global styles
└── README.md         # Project documentation
```

---

## 🛠️ Installation Guide  

### Prerequisites:  
- PHP 7.0+  
- MySQL 5.6+  
- Apache/Nginx server  

### Setup Steps:  
1. **Clone the repository**:  
   ```bash
   git clone https://github.com/chstridho/crud-manajemenbuku.git
   ```

2. **Import database schema**:  
   - Create MySQL database: `manajemen_buku`  
   - Import table structure from included SQL file  

3. **Configure database connection**:  
   Edit `koneksi.php` with your credentials:  
   ```php
   $host = "localhost";
   $user = "your_username";
   $pass = "your_password";
   $db   = "manajemen_buku";
   ```

4. **Launch application**:  
   Access via web server:  
   ```
   http://localhost/crud-manajemenbuku
   ```

---

## 💻 Usage Guide  
1. **View Books**:  
   - All books display on the homepage (`index.php`)  

2. **Add New Book**:  
   - Click "Tambah Buku Baru" button  
   - Fill form in `tambah.php`  

3. **Edit Book**:  
   - Click "Edit" button on book entry  
   - Modify details in `edit.php`  

4. **Delete Book**:  
   - Click "Hapus" button on book entry  
   - Confirm deletion in `hapus.php`  

5. **Search Books**:  
   - Use search bar at top of homepage  

---

## 🤝 Contribution  
Contributions are welcome! Please:  
1. Fork the repository  
2. Create your feature branch (`git checkout -b feature/your-feature`)  
3. Commit your changes (`git commit -am 'Add some feature'`)  
4. Push to the branch (`git push origin feature/your-feature`)  
5. Open a pull request  

---

## 📬 Contact  
**Chesta Ridho**  
- GitHub: [@chstridho](https://github.com/chstridho)  
- Project Link: [https://github.com/chstridho/crud-manajemenbuku](https://github.com/chstridho/crud-manajemenbuku)  

---

**Happy Coding!** 💻📚
