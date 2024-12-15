-- Select all columns from the Users table
SELECT * FROM Users;

-- Select specific columns from the Users table
SELECT UserID, FirstName, LastName, Email FROM Users;

-- Select all columns from the Products table
SELECT * FROM Products;

-- Select specific columns from the Products table
SELECT ProductID, ProductName, Category, Price, InStock FROM Products;

-- Select all columns from the Orders table
SELECT * FROM Orders;

-- Select specific columns from the Orders table
SELECT OrderID, UserID, ProductID, Quantity, OrderDate FROM Orders;

-- Select orders with user and product details
SELECT 
  o.OrderID, 
  u.FirstName, 
  u.LastName, 
  p.ProductName, 
  o.Quantity, 
  o.OrderDate
FROM Orders o
JOIN Users u ON o.UserID = u.UserID
JOIN Products p ON o.ProductID = p.ProductID;