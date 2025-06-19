<?php include 'customer_navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boat Safari - Home</title>
    <link rel="stylesheet" href="./css/insert.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <style>
        .hero {
            background: linear-gradient(120deg, #007bff 60%, #0056b3 100%);
            color: #fff;
            padding: 60px 0 40px 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 2.8em;
            margin-bottom: 16px;
        }
        .hero p {
            font-size: 1.3em;
            margin-bottom: 32px;
        }
        .book-btn {
            background: #fff;
            color: #007bff;
            font-size: 1.2em;
            padding: 14px 36px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s, color 0.2s;
        }
        .book-btn:hover {
            background: #0056b3;
            color: #fff;
        }
        .featured-safaris {
            margin: 40px auto 0 auto;
            max-width: 900px;
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            justify-content: center;
        }
        .safari-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 28px 24px;
            width: 270px;
            text-align: left;
        }
        .safari-card h3 {
            margin-top: 0;
            color: #007bff;
        }
        .safari-card p {
            color: #444;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="hero">
            <h1>Welcome to Boat Safari Adventures!</h1>
            <p>Experience the thrill of the wild and the beauty of the water.<br>Book your unforgettable safari today.</p>
            <a href="/useracc/book_safari.php"><button class="book-btn">Book Now</button></a>
        </div>
        <div class="featured-safaris">
            <div class="safari-card">
                <h3>Morning Bird Watching</h3>
                <p>Start your day with the sights and sounds of rare birds. Perfect for nature lovers and photographers.</p>
            </div>
            <div class="safari-card">
                <h3>Sunset Cruise</h3>
                <p>Enjoy a magical sunset on the water, with snacks and drinks provided. Great for couples and families.</p>
            </div>
            <div class="safari-card">
                <h3>Mangrove Exploration</h3>
                <p>Discover the hidden world of the mangroves and spot unique wildlife with our expert guides.</p>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 