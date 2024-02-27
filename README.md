# Project Title

Simple project with protected blog section for only subscribers and once the
subscriber logged in for the first time it can’t login from other device in the future.

## Table of Contents

- [Introduction](#introduction)
- [Technologies Used](#technologies-used)
- [Features](#features)
- [Setup](#setup)
- [Usage](#usage)
- [Code and Flow Explanation](#code-and-flow-explanation)
- [Challenges and Solutions](#challenges-and-solutions)
- [Enhancements](#enhancements)
- [Conclusion](#conclusion)
- [Notes](#notes)

## Introduction

project with protected blog section for only subscribers, subscribers section for only admins and for both blogs and subscribers the whole CRUD operations plus search(by name/title) and advanced search (search for the rest of mendatory fields). once the subscriber logged in for the first time it can’t login from other device in the future

## Technologies Used

### Frontend

- **vue.js**: Version 3.4.15.
- **vuex**: Version 4.1.0.
- **vue-router**: Version 4.3.0.
- **axios**: Version 1.6.7.
- **vue3-toastify**: Version 0.2.1.
- **vuetify**: Version 3.4.0-beta.1.

### Backend

- **Laravel**: Version 10.10.
- **laravel/sanctum**: Version 3.3.
- **fakerphp/faker**: Version 1.9.1.

## Features & Structure

### Backend

This project is built with a focus on robustness, reusability, and security, employing a variety of programming concepts and tools to achieve a high-quality application architecture. Below is an overview of the key technologies and methodologies used:

#### Modular Design

- **Modules**: The application is structured into modules, making it easier to manage, develop, and test discrete functionalities independently.

#### Database Management

- **Seeders** and **Factories**: Leveraged for database seeding and factory patterns to efficiently generate and manage test data, enhancing the development and testing process.

#### Data Handling

- **DTOs (Data Transfer Objects)**: Utilized to transfer data between processes, improving data integrity and the security of data transfer.
- **Form Requests**: Employed to validate and handle user input securely and efficiently.

#### Service Layer

- **Services**: Implemented a service layer to encapsulate business logic, ensuring a clean separation between the application's UI and business rules.

#### Security Features

- **Device Fingerprinting**: Integrated fingerprinting technology to prevent users from logging other device after the first login.
- **Constant Classes**: Used constant classes to manage fixed values across the application, ensuring code consistency and ease of maintenance.

## Frontend

The frontend of this project is designed to offer a seamless and intuitive user experience, leveraging the latest in web development technologies and best practices. Here's an overview of the key frontend technologies and tools used:

### State Management
- **Vuex**: Employed for centralized state management, facilitating communication and data sharing across components.

### Routing
- **Vue Router**: Enabling navigation between different components without reloading the page, thereby improving performance and user experience.

### UI Components
- **Vuetify**: UI framework to create a visually appealing and responsive interface with a consistent design system.

### HTTP Requests
- **Axios**: Used for promise-based HTTP client to handle asynchronous requests to the backend, offering a straightforward way to interact with APIs and manage data fetching and other HTTP operations.

### Notifications
- **Vue3-toastify**: Incorporated to display informative and interactive notifications to users and responsive toast messages.

### Authentication and Authorization
- **AuthMiddleware & AdminMiddleware**: Custom middleware implemented to manage authentication and authorization processes, ensuring __all protected pages__ only accessable by __only auth users__ and enforcing role-based access to allow __only admin__ to access __subscriber__ page.

## Setup

Instructions on how to get a local copy up and running.

```bash
git clone [repository_url]
cd [local_repository_name/client]
npm run install
npm run start

cd [local_repository_name/server]
php artisan serve
```
