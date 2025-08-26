# NHIA Claims Manager

A comprehensive Laravel 10 application for managing National Health Insurance Authority (NHIA) claims in Ghana. This application provides a complete solution for healthcare providers to submit, track, and manage medical claims with full audit trails and reporting capabilities.

## Features

### Core Functionality

-   **Claims Management**: Create, edit, and track medical claims with multi-step workflow
-   **Provider Management**: Manage healthcare providers with NHIS codes and contact information
-   **Beneficiary Management**: Track NHIS beneficiaries with validation and expiry dates
-   **Tariff Management**: Maintain service tariffs for consultations, labs, drugs, and procedures
-   **Status Workflow**: Complete claim lifecycle from Draft → Submitted → UnderReview → Approved/Rejected → Paid
-   **Audit Trail**: Full tracking of all changes and actions in the system

### Advanced Features

-   **Multi-step Claim Creation**: Wizard-style claim creation with provider/beneficiary selection
-   **Real-time Calculations**: Automatic calculation of claim totals and item amounts
-   **File Attachments**: Upload and manage supporting documents (images, PDFs)
-   **Comprehensive Reporting**: Generate detailed reports with filtering and export options
-   **PDF/CSV Export**: Export claims and reports in multiple formats
-   **Search & Filtering**: Advanced search and filtering across all modules

### Business Rules

-   NHIS number validation with regex pattern `^[A-Za-z0-9]{10,15}$`
-   Beneficiary expiry date validation
-   Claim status transition rules
-   Automatic claim number generation (CLM-YYYYMM-XXXXX format)
-   Prevention of deletion for entities with linked claims

## Technology Stack

-   **Framework**: Laravel 10 (PHP 8.1+)
-   **Database**: SQLite (default) / MySQL / PostgreSQL
-   **Frontend**: Blade templates with Bootstrap 5
-   **Authentication**: Laravel Breeze
-   **PDF Generation**: DomPDF
-   **Icons**: Font Awesome 6
-   **JavaScript**: jQuery + Bootstrap JS

## Installation

### Prerequisites

-   PHP 8.1 or higher
-   Composer
-   Node.js & NPM (for asset compilation)

### Step 1: Clone and Install Dependencies

```bash
git clone <repository-url>
cd nhia-claims-manager
composer install
npm install
```

### Step 2: Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### Step 3: Database Configuration

Edit `.env` file and configure your database:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

Or for MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nhia_claims
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 4: Run Migrations and Seed Data

```bash
php artisan migrate --seed
```

### Step 5: Build Assets

```bash
npm run build
```

### Step 6: Start the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default Login Credentials

The seeder creates two demo users:

-   **Admin User**

    -   Email: `admin@example.com`
    -   Password: `password`

-   **Regular User**
    -   Email: `user@example.com`
    -   Password: `password`

## Demo Data

The application comes with sample data including:

-   3 Healthcare Providers (Legon Clinic, Kumasi Hospital, Tema General)
-   3 Beneficiaries with valid NHIS numbers
-   8 Service Tariffs (consultations, labs, drugs, procedures)
-   5 Sample Claims with items

## Application Structure

### Models

-   `User`: Authentication and user management
-   `Provider`: Healthcare providers with NHIS codes
-   `Beneficiary`: NHIS beneficiaries with validation
-   `Tariff`: Service tariffs and pricing
-   `Claim`: Main claims with workflow status
-   `ClaimItem`: Individual items within claims
-   `Attachment`: File attachments for claims
-   `AuditTrail`: System audit logging

### Controllers

-   `DashboardController`: Dashboard statistics and charts
-   `ProviderController`: CRUD operations for providers
-   `BeneficiaryController`: CRUD operations for beneficiaries
-   `TariffController`: CRUD operations for tariffs
-   `ClaimController`: Complete claim management with workflow
-   `AttachmentController`: File upload and management
-   `ReportController`: Comprehensive reporting system

### Key Features

#### Claims Workflow

1. **Draft**: Initial claim creation
2. **Submitted**: Claim submitted for review
3. **UnderReview**: Claim being reviewed
4. **Approved**: Claim approved for payment
5. **Rejected**: Claim rejected (final state)
6. **Paid**: Payment processed (final state)

#### Validation Rules

-   NHIS numbers must match pattern `^[A-Za-z0-9]{10,15}$`
-   Beneficiary expiry dates must be valid
-   Claim dates must not exceed beneficiary expiry
-   Status transitions follow business rules
-   Unique constraints on provider NHIS codes and beneficiary NHIS numbers

#### Reporting

-   Claims summary with filtering
-   Provider performance analysis
-   Beneficiary utilization reports
-   Export to PDF and CSV formats
-   Date range filtering
-   Status-based filtering

## API Endpoints

The application includes RESTful API endpoints for all major operations:

-   `GET /api/providers` - List providers
-   `POST /api/providers` - Create provider
-   `GET /api/beneficiaries` - List beneficiaries
-   `POST /api/beneficiaries` - Create beneficiary
-   `GET /api/claims` - List claims
-   `POST /api/claims` - Create claim
-   `PATCH /api/claims/{id}/status` - Update claim status

## Security Features

-   CSRF protection on all forms
-   Input validation and sanitization
-   SQL injection prevention
-   XSS protection
-   File upload security
-   Role-based access control (ready for implementation)

## Customization

### Adding New Status Types

Edit the `Claim` model's `canTransitionTo` method to add new status transitions.

### Custom Validation Rules

Add new validation rules in the respective model classes.

### Additional Report Types

Extend the `ReportController` with new report methods.

## Troubleshooting

### Common Issues

1. **Memory Limit Exceeded**

    - Increase PHP memory limit: `php -d memory_limit=1G artisan migrate --seed`

2. **Database Connection Issues**

    - Verify database credentials in `.env`
    - Ensure database server is running

3. **File Upload Issues**

    - Check storage directory permissions
    - Verify `storage/app/attachments` directory exists

4. **PDF Generation Issues**
    - Install required system fonts
    - Check DomPDF configuration

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please contact the development team or create an issue in the repository.

---

**NHIA Claims Manager** - Streamlining healthcare claims management in Ghana
