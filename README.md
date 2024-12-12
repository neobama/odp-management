
# ODP Management System

ODP Management System is a Laravel-based application designed to manage ODP (Optical Distribution Point) data, clients, and their geographical locations. This system includes features such as displaying ODPs on a map, searching for the nearest ODP, and managing client data within each ODP.

## Features

- **ODP Management**:
  - Create, edit, and delete ODPs.
  - Display all ODPs on an interactive map using Leaflet.js.
  - Visual indicators for ODP capacity utilization (red, yellow, green markers).

- **Client Management**:
  - Assign clients to specific ODPs.
  - View client details within each ODP.

- **Search and Navigation**:
  - Search for ODPs and clients by name.
  - Locate the nearest ODP based on a given geographical location.

- **User-Friendly Dashboard**:
  - Overview of total ODPs, clients, and full-capacity ODPs.
  - Interactive map view for quick navigation.

## Installation

### Prerequisites
- PHP >= 8.0
- Composer
- Node.js & npm
- MySQL or other supported database

### Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/odp-management.git
   cd odp-management
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   npm run dev
   ```

3. Configure the environment:
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Set the database credentials and other configurations in the `.env` file.

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. Start the development server:
   ```bash
   php artisan serve
   ```

7. Access the application at `http://127.0.0.1:8000`.

## Usage

### Admin Dashboard
- Navigate to the dashboard to view ODP summaries, client details, and the interactive map.

### Find Nearest ODP
- Use the "Find Nearest ODP" feature to locate the nearest ODP based on a specific latitude and longitude.

### Add ODPs and Clients
- Add new ODPs with geographical coordinates via the ODP management interface.
- Assign clients to ODPs to track capacity utilization.

### Map Visualization
- View all ODPs on the home summary map.
  - **Red Marker**: Full capacity.
  - **Yellow Marker**: More than 50% capacity utilized.
  - **Green Marker**: Less than 50% capacity utilized.

## API Endpoints

- **Find Nearest ODP**:
  - **POST** `/find-nearest-odp`
  - Request payload: `{ "latitude": <float>, "longitude": <float> }`
  - Response: Nearest ODP details with distance in kilometers.

- **Fetch ODP Data**:
  - **GET** `/api/odps`

## Technologies Used

- **Backend**: Laravel
- **Frontend**: Blade, Bootstrap
- **Map**: Leaflet.js
- **Database**: MySQL
```
