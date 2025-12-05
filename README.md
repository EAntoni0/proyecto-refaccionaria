# 📦 Auto Parts Store Management System

A comprehensive web platform for the administration of an automotive spare parts store.  
The system manages the complete business workflow: from inventory control and warehouse entries to the Point of Sale (POS) and managerial administration.

Built with a modern monolithic architecture using the **TALL stack** (Tailwind, Alpine, Laravel, Livewire).

---

## 🚀 Key Features

The system includes **Role-Based Access Control (RBAC)** with three defined profiles:

---

### 👨‍💼 Administrator (Management)

- **User Management:** Full CRUD for employees with role assignment  
- **Catalog Management:** Categories and Products administration (including image upload)  
- **Inventory Monitor:** Read-only view to audit stock in real-time and total warehouse valuation  
- **Stock Alerts:** Visual indicators for critical or low stock


 ![admin](/public/images/admin.png)

---

### 👷 Warehouseman (Logistics)

- **Entry Management:** Registration of incoming merchandise  
- **Movement Log (Kardex):** Complete history of inventory movements  
- **Quick Search:** Product filtering by name for fast adjustments

![admin](/public/images/almacenista.png)

---


### 🛒 Seller (Point of Sale)

- **Interactive POS:** Fast and intuitive sales interface  
- **Shopping Cart:** Dynamic product addition with auto-total calculation  
- **Stock Validation:** Real-time prevention of out-of-stock sales  
- **Visual Alerts:** Status notifications for each transaction  

![admin](/public/images/seller.png)

---

## 🛠️ Tech Stack

- **Backend:** Laravel  
- **Frontend:** Blade + Livewire 3  
- **Styling:** Tailwind CSS + Flowbite  
- **Database:** MySQL  

### 📚 Key Libraries

- `rappasoft/laravel-livewire-tables` – Dynamic data tables  
- `sweetalert2` – UI notifications  
- `font-awesome` – Icon set  

---

## ⚙️ Installation Guide

Follow these steps to deploy the project locally:

### 1️⃣ Clone the repository
```bash
git clone https://github.com/tu-repo.git
cd tu-repo

