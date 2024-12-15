-- Update the price of a product
UPDATE Products
SET Price = 549.99
WHERE ProductID = 2;

-- Update the quantity of an order
UPDATE Orders
SET Quantity = 2
WHERE OrderID = 3;

-- Update the stock level of a product
UPDATE Products 
SET InStock = InStock - 10
WHERE ProductID = 1;