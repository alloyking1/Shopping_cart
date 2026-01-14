# E-commerce Shopping Cart - Project Milestones

## Overview

This document outlines the milestones for building a simple e-commerce shopping cart system with Laravel and Vue.

---

## **Milestone 1: Database Schema & Models** 🔨

**Goal**: Set up the database structure and Eloquent models

### Tasks:

- [ ] Create `products` migration (name, price, stock_quantity, timestamps)
- [ ] Create `cart_items` migration (user_id, product_id, quantity, timestamps)
- [ ] Create `orders` migration (user_id, total_amount, created_at, updated_at)
- [ ] Create `order_items` migration (order_id, product_id, quantity, price_at_purchase, timestamps)
- [ ] Create `Product` model with relationships and validation rules
- [ ] Create `CartItem` model with relationships to User and Product
- [ ] Create `Order` model with relationships
- [ ] Create `OrderItem` model with relationships
- [ ] Update `User` model to add relationships (cartItems, orders)
- [ ] Run migrations and verify schema

**Deliverables**:

- All migrations created and tested
- All models created with proper relationships
- Database schema documented

---

## **Milestone 2: Products Seeding & Management** 📦

**Goal**: Populate products and set up basic product management

### Tasks:

- [ ] Create `ProductFactory` for testing/development
- [ ] Create `ProductSeeder` with sample products
- [ ] Seed database with initial products
- [ ] Create `ProductController` with `index()` method returning `Inertia::render('Products/Index', [...])`
- [ ] Test product retrieval via Inertia response

**Deliverables**:

- Database seeded with sample products
- ProductController returns Inertia response with products data
- Ready for frontend integration

---

## **Milestone 3: Shopping Cart Backend Logic (Inertia Controllers)** 🛒

**Goal**: Implement cart operations (add, update, remove) with proper validation using Inertia responses

### Tasks:

- [ ] Create `CartController` with Inertia-style methods:
    - `index()` - Return `Inertia::render('Cart/Index', [...])` with user's cart items
    - `store()` - Add item to cart, return `RedirectResponse` (redirect back with flash message)
    - `update()` - Update item quantity, return `RedirectResponse` (redirect back)
    - `destroy()` - Remove item from cart, return `RedirectResponse` (redirect back)
- [ ] Create Form Request classes for validation:
    - `StoreCartItemRequest`
    - `UpdateCartItemRequest`
- [ ] Implement cart business logic:
    - Check stock availability
    - Prevent adding items exceeding stock
    - Update quantities with stock validation
    - Calculate cart totals
- [ ] Create routes for cart operations (web routes, not API routes)
- [ ] Add authorization (users can only manage their own cart)
- [ ] Use `Inertia::render()` for GET requests and `RedirectResponse` for POST/PUT/DELETE

**Deliverables**:

- Fully functional cart backend controllers (Inertia-style, not API)
- Controllers return Inertia responses (`Inertia::render()`) or redirects
- Proper validation and error handling
- Stock checking logic implemented

---

## **Milestone 4: Shopping Cart Frontend (Vue/Inertia)** 🎨

**Goal**: Build the user interface for browsing products and managing cart

### Tasks:

- [ ] Create `Products/Index.vue` page (product listing)
- [ ] Create `Cart/Index.vue` page (cart view)
- [ ] Create product card component (reusable)
- [ ] Create cart item component (with update/remove actions)
- [ ] Add navigation links to products and cart
- [ ] Implement add to cart functionality
- [ ] Implement update quantity functionality
- [ ] Implement remove from cart functionality
- [ ] Display cart item count in navigation
- [ ] Add proper loading states and error handling
- [ ] Style with Tailwind CSS (responsive design)

**Deliverables**:

- Fully functional shopping cart UI
- Products can be browsed and added to cart
- Cart can be viewed and managed
- Clean, modern design with Tailwind

---

## **Milestone 5: Order Processing & Sales Tracking** 💰

**Goal**: Enable checkout functionality and track sales for reporting

### Tasks:

- [ ] Create `OrderController` with:
    - `store()` method (checkout) - returns `RedirectResponse` to order confirmation
    - `show($id)` method - returns `Inertia::render('Orders/Show', [...])` for order confirmation page
- [ ] Implement order creation logic:
    - Create order from cart items
    - Store product prices at purchase time
    - Clear cart after order creation
    - Update product stock quantities
- [ ] Create order confirmation Vue page (`Orders/Show.vue`)
- [ ] Add order routes (web routes)
- [ ] Test order creation and stock updates

**Deliverables**:

- Users can checkout and create orders (Inertia-style)
- Order confirmation page displays order details
- Stock is updated when orders are created
- Sales data is tracked for reporting

---

## **Milestone 6: Low Stock Notification (Queue/Job)** 📧

**Goal**: Send email notifications when product stock is low

### Tasks:

- [ ] Create `LowStockNotification` job class
- [ ] Implement job logic:
    - Check if stock is below threshold (e.g., 10 units)
    - Send email to admin user
    - Include product details in email
- [ ] Trigger job when stock is updated (observer or event)
- [ ] Configure queue driver (database)
- [ ] Create admin user seeder (dummy admin for testing)
- [ ] Test job execution and email delivery
- [ ] Add email template/view for low stock notification

**Deliverables**:

- Low stock notifications sent via queue
- Email template for notifications
- Admin user created for testing

---

## **Milestone 7: Daily Sales Report (Scheduled Command)** 📊

**Goal**: Implement daily scheduled job to send sales reports

### Tasks:

- [ ] Create `DailySalesReport` command class
- [ ] Implement command logic:
    - Query orders from today
    - Calculate total sales
    - Get list of products sold
    - Generate report data
- [ ] Create email template for sales report
- [ ] Send email to admin user
- [ ] Schedule command in `app/Console/Kernel.php` (daily at evening time)
- [ ] Test command manually
- [ ] Document how to test scheduled tasks

**Deliverables**:

- Daily sales report command created
- Command scheduled to run daily
- Email template for sales report
- Documentation for testing

---

## **Milestone 8: Testing & Final Polish** ✅

**Goal**: Add tests and polish the application

### Tasks:

- [ ] Write feature tests for:
    - Product browsing
    - Adding items to cart
    - Updating cart quantities
    - Removing items from cart
    - Order creation
    - Stock validation
- [ ] Write unit tests for models and business logic
- [ ] Test low stock notification job
- [ ] Test daily sales report command
- [ ] Fix any bugs or issues
- [ ] Code cleanup and documentation
- [ ] Update README with setup instructions
- [ ] Prepare for GitHub submission

**Deliverables**:

- Comprehensive test coverage
- All features tested and working
- Clean, documented code
- README updated
- Ready for GitHub submission

---

## **Notes**:

- Each milestone builds upon the previous one
- We'll get approval before proceeding to the next milestone
- Following Laravel best practices (Form Requests, Eloquent relationships, Service classes if needed)
- Clean separation of concerns (Controllers, Models, Jobs, Commands)
- Using Vue 3 Composition API with TypeScript
- Tailwind CSS for styling

---

## **Tech Stack Confirmed**:

- ✅ Backend: Laravel 12
- ✅ Frontend: Vue 3 + Inertia.js
- ✅ Authentication: Laravel Fortify (already configured)
- ✅ Styling: Tailwind CSS (already configured)
- ✅ Queue: Laravel Queue (database driver)
- ✅ Scheduling: Laravel Task Scheduler
