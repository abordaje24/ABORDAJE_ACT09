-- Insert sample data into the Users table
INSERT INTO Users (FirstName, LastName, Email)
VALUES
  ('John', 'Doe', 'john.doe@example.com'),
  ('Jane', 'Smith', 'jane.smith@example.com'),
  ('Michael', 'Johnson', 'michael.johnson@example.com'),
  ('Emily', 'Davis', 'emily.davis@example.com'),
  ('David', 'Wilson', 'david.wilson@example.com');

-- Insert sample data into the Products table  
INSERT INTO Products (ProductName, Category, Price, InStock)
VALUES
  ('Laptop', 'Electronics', 899.99, 25),
  ('Smartphone', 'Electronics', 499.99, 50),
  ('T-Shirt', 'Clothing', 19.99, 100),
  ('Jeans', 'Clothing', 39.99, 75),
  ('Headphones', 'Electronics', 79.99, 30);

-- Insert sample data into the Orders table
INSERT INTO Orders (UserID, ProductID, Quantity)
VALUES
  (1, 2, 1),
  (2, 1, 1),
  (3, 4, 2),
  (1, 3, 3),
  (4, 5, 1),
  (2, 2, 1),
  (5, 1, 1);