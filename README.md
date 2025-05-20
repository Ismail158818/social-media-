# Project Description

## Project Idea
This project is a web application built using the Laravel framework, aiming to provide an interactive platform for users where they can create and manage posts, comment on them, manage groups, and interact with other users. The project also provides an Application Programming Interface (API) for system interaction.

## Technical Structure
- **app/**: Contains the core project code.
  - **Http/Controllers/**: Contains project controllers such as UserController, PostController, GroupController, CommentController, TagsController, AdminController, and other files.
  - **Models/**: Contains data models such as User, Post, Group, Comment, Tag, and others.
  - **View/**: Contains view files.
  - **Providers/**: Contains service providers.
- **routes/**: Contains routing files such as web.php and api.php.
- **resources/views/**: Contains view templates such as posts pages, profile, and others.
- **config/**: Contains configuration files.
- **database/**: Contains database files.
- **public/**: Contains public files such as CSS and JavaScript.
- **storage/**: Contains stored files.
- **tests/**: Contains test files.
- **vendor/**: Contains external libraries.

## Core Features

### User Management
- Login and Registration
- Personal Information Management
- Following Other Users
- View Followers and Following Lists
- Permission Management (Regular User, Moderator, Admin)

### Post Management
- Create New Posts
- View Posts
- Edit Posts
- Delete Posts
- Vote on Posts (Like/Dislike)
- Search Posts
- Filter Posts by Tags

### Group Management
- Create New Groups
- Join Groups
- Manage Group Members
- Post in Groups
- Group Permission Management
- Search Groups
- Filter Groups by Tags

### Comment Management
- Add Comments to Posts
- View Comments
- Delete Comments
- Edit Comments

### Tag Management
- Add New Tags
- Link Tags to Posts
- Search Tags
- Filter Content by Tags

### Reporting System
- Report Posts
- Report Groups
- Report Users
- View Reports List for Moderators
- Handle Reports (Accept/Reject)
- Ban Violating Users
- Delete Violating Content

### Notification System
- Follow Notifications
- Comment Notifications
- Like Notifications
- Report Notifications
- Group Notifications

### Application Programming Interface (API)
- User Login and Registration
- Post Management
- Comment Management
- Group Management
- Tag Management
- User Management

## Technologies and Packages Used
- **Laravel**: PHP Framework
- **Chatify**: Chat Package
- **Firebase**: Cloud Service
- **TailwindCSS**: CSS Framework
- **Vite**: Build Tool
- **Alpine.js**: JavaScript Library
- **Select2**: JavaScript Library
- **Axios**: JavaScript Library

## Interfaces and Pages
- **Posts Page**: View posts, add new posts, search and filter
- **Profile Page**: View user information, posts, followers, following
- **Groups Page**: View groups, create new groups, manage groups
- **Tags Page**: View tags, add new tags, search tags
- **Admin Page**: Manage users, posts, groups, tags, reports
- **Reports Page**: View reports, handle reports, manage violating content

## Conclusion
This project provides a comprehensive interactive platform for users to interact with each other through posts, comments, and groups. It also offers a robust content management system with the ability to report and handle violating content. The project supports future expansion and development while maintaining user and content safety and security.
