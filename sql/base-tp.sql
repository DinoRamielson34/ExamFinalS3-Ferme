-- Création de la table users
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    role ENUM('client', 'admin') DEFAULT 'client'
);
-- Création de la table properties
CREATE TABLE properties (
    id SERIAL PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    nbChambre INT NOT NULL,
    loyer DECIMAL(10, 2) NOT NULL,
    photos TEXT,
    neighborhood VARCHAR(100),
    description TEXT
);
-- Création de la table reservations
CREATE TABLE reservations (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id),
    property_id INT REFERENCES properties(id),
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- (Optionnel) Création de la table availability
CREATE TABLE availability (
    id SERIAL PRIMARY KEY,
    property_id INT REFERENCES properties(id),
    date DATE NOT NULL,
    is_available BOOLEAN DEFAULT TRUE
);

INSERT INTO properties (type, nbChambre, loyer, photos, neighborhood, description) VALUES
('Apartment', 2, 500000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Downtown', 'Modern 2-bedroom apartment in the heart of the city.'),
('House', 3, 1000000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Suburbia', 'Spacious 3-bedroom house with a backyard and garage.'),
('Condo', 1, 600000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'City Center', 'Cozy 1-bedroom condo with city views.'),
('Studio', 1, 500000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'East Side', 'Charming studio apartment close to public transport.'),
('Loft', 2, 900000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Industrial District', 'Stylish loft with high ceilings and modern amenities.'),
('Villa', 4, 2000000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Lakeside', 'Luxurious villa with stunning lake views and a pool.'),
('Townhouse', 3, 1200000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Cottage Grove', 'Beautiful townhouse with a community park nearby.'),
('Bungalow', 2, 700000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Greenwood', 'Charming bungalow with a large garden.'),
('Penthouse', 3, 3000000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Uptown', 'Exclusive penthouse with panoramic city views.'),
('Cottage', 2, 550000.00, '["photo1a.jpg", "photo11b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Countryside', 'Quaint cottage perfect for a weekend getaway.');

INSERT INTO properties (type, nbChambre, loyer, photos, neighborhood, description) VALUES
('Apartment', 2, 600000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Downtown', 'Stylish 2-bedroom apartment with modern furnishings.'),
('House', 4, 1200000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Suburbia', 'Large 4-bedroom house with a spacious backyard.'),
('Condo', 2, 700000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'City Center', 'Modern condo with amenities and city views.'),
('Studio', 1, 550000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'East Side', 'Compact studio with all essentials in a great location.'),
('Loft', 3, 1000000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Industrial District', 'Loft with exposed brick and modern decor.'),
('Villa', 5, 2500000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Lakeside', 'Spacious villa with a private pool and lake access.'),
('Townhouse', 4, 1500000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Cottage Grove', 'Elegant townhouse with a modern kitchen.'),
('Bungalow', 3, 800000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Greenwood', 'Cozy bungalow with a beautiful garden.'),
('Penthouse', 4, 4000000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Uptown', 'Luxury penthouse with stunning views and rooftop access.'),
('Cottage', 2, 600000.00, '["photo1a.jpg", "photo11b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Countryside', 'Charming cottage with rustic features.'),
('Apartment', 1, 550000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Downtown', 'Chic 1-bedroom apartment with great amenities.'),
('House', 3, 800000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Suburbia', 'Beautiful 3-bedroom house with a garage.'),
('Condo', 2, 700000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'City Center', 'Spacious condo with access to a pool.'),
('Studio', 1, 600000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'East Side', 'Lovely studio close to cafes and shops.'),
('Loft', 3, 1000000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Industrial District', 'Trendy loft with high ceilings and natural light.'),
('Villa', 4, 2200000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Lakeside', 'Elegant villa with a lakefront view.'),
('Townhouse', 3, 1500000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Cottage Grove', 'Modern townhouse with community amenities.'),
('Bungalow', 2, 700000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Greenwood', 'Quaint bungalow with a lovely porch.'),
('Penthouse', 3, 3500000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Uptown', 'Exclusive penthouse with modern amenities.'),
('Cottage', 2, 600000.00, '["photo1a.jpg", "photo11b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Countryside', 'Charming cottage with a rustic feel.'),
('Apartment', 3, 900000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Downtown', 'Spacious apartment in a vibrant neighborhood.'),
('House', 4, 1200000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Suburbia', 'Family-friendly 4-bedroom house with a garden.'),
('Condo', 1, 650000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'City Center', 'Affordable condo with great views.'),
('Studio', 1, 600000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'East Side', 'Compact studio with easy access to transport.'),
('Loft', 2, 1200000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Industrial District', 'Stylish loft with contemporary design.'),
('Villa', 5, 5000000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Lakeside', 'Luxury villa with a scenic backdrop.'),
('Townhouse', 3, 1800000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Cottage Grove', 'Spacious townhouse with modern amenities.'),
('Bungalow', 2, 800000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Greenwood', 'Charming bungalow with a beautiful yard.'),
('Penthouse', 3, 4500000.00, '["photo1a.jpg", "photo1b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Uptown', 'Penthouse with breathtaking city views.'),
('Cottage', 2, 700000.00, '["photo1a.jpg", "photo11b.jpg", "photo1c.jpg", "photo1d.jpg"]', 'Countryside', 'Relaxing cottage perfect for a retreat.');