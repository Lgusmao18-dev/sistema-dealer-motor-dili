<div align="center">
  <img src="assets/logo.png" alt="Lgusmao18-dev Logo" width="180" />
  
  <h1>🏍️ Sistema Informasaun GIS Dealer Motor Dili</h1>

  <p>
    <strong>A Modern Web-Based GIS Information System for Motorcycle Dealers in Dili, Timor-Leste</strong>
  </p>

  <p>
    <a href="https://php.net/"><img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" /></a>
    <a href="https://www.mysql.com/"><img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" /></a>
    <a href="https://getbootstrap.com/"><img src="https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap" /></a>
    <a href="#"><img src="https://img.shields.io/badge/Status-Active-success?style=for-the-badge" alt="Status" /></a>
  </p>
</div>

---

## 📖 About The Project

**Sistema Informasaun GIS Dealer Motor Dili** is a web-based geographic information system (GIS) designed to help users locate official motorcycle dealers in Dili, Timor-Leste. Developed using PHP and MySQL, the platform features an interactive map, live GPS integration, and complete information regarding motorcycle dealerships and brands available in the area.

This system provides a modern platform with dual portals: a public-facing map directory for users, and a secure Admin Dashboard for system administrators to manage dealer registrations, user interactions, and view platform analytics.

<br />

## ✨ Key Features

Here are the powerful features that make this system stand out:

| Icon | Feature | Description |
| :---: | :--- | :--- |
| 🗺️ | **Interactive GIS Map** | Find official motorcycle dealers on an interactive map with live GPS tracking. |
| 🔍 | **Advanced Search** | Easily search for dealers by name, motorcycle brand, or specific location. |
| 📊 | **Admin Dashboard** | Comprehensive control panel for administrators to manage the platform. |
| 🏢 | **Dealer Management** | Register, update, and manage official motorcycle dealers *(Jere Dellear)*. |
| 👥 | **User Management** | Secure administration of system users and their roles *(Jere Utilizador)*. |
| ✉️ | **Feedback System** | Track and manage customer messages and reviews *(Komentariu Cliente)*. |
| 📈 | **Analytics** | Monitor total registered dealers, brands, customer messages, and site visits. |
| 🌐 | **Localization** | Fully localized user interface in Tetum. |

<br />

## 🛠️ Built With

*   **Backend:** [PHP](https://php.net/)
*   **Database:** [MySQL](https://www.mysql.com/)
*   **Frontend UI/UX:** HTML5, CSS3, JavaScript
*   **Mapping:** GIS Integration (e.g., Leaflet / Google Maps API)

<br />

## 📸 Screenshots

| Public Landing Page | Admin Dashboard |
| :---: | :---: |
| <img src="docs/public_landing.png" alt="Public Landing Page" width="400" /> | <img src="docs/admin_dashboard.png" alt="Admin Dashboard" width="400" /> |
| *Modern interface for users to search and explore the map.* | *Comprehensive statistics and dealer management.* |

> **Note:** Please add your screenshots to a `docs/` folder in your repository and name them `public_landing.png` and `admin_dashboard.png` (or update the links above) to display them correctly on GitHub.

<br />

## 🚀 Getting Started

Follow these steps to set up the project locally on your machine.

### Prerequisites

Ensure you have a local server environment installed, such as:
*   [XAMPP](https://www.apachefriends.org/index.html)
*   [WAMP](https://www.wampserver.com/en/)
*   [MAMP](https://www.mamp.info/)

### Installation

1.  **Clone the repository**
    ```sh
    git clone https://github.com/your-username/sistema-dealer-motor-dili.git
    ```
2.  **Move the project**
    Move the cloned project folder to your local server's root directory (e.g., `htdocs` for XAMPP or `www` for WAMP).
3.  **Database Setup**
    *   Open your database manager (e.g., phpMyAdmin).
    *   Create a new database (e.g., `dealer_motor_db`).
    *   Import the provided `.sql` file (usually found in an `sql` or `database` folder within the project) into the newly created database.
4.  **Configure Database Connection**
    *   Open the database configuration file (e.g., `config.php`, `db.php`, or `.env`).
    *   Update the database credentials (host, username, password, database name) to match your local setup.
5.  **Run the Application**
    *   Start Apache and MySQL on your local server environment.
    *   Open a web browser and navigate to `http://localhost/sistema-dealer-motor-dili`.

<br />

## 🔒 Access Credentials

*(Optional: Remove or update this section before deploying to production!)*

**Admin Panel:**
*   **URL:** `http://localhost/sistema-dealer-motor-dili/admin` (or similar path)
*   **Username:** `admin`
*   **Password:** `password`

<br />

## 🤝 Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<br />

---
<div align="center">
Developed with ❤️ for Timor-Leste
</div>
