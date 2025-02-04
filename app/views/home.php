<?php
$base_url = Flight::get('flight.base_url') . '';
?>
<section class="product-list">
    <?php foreach ($properties as $property): ?>
        <article class="product-card">
            <a href="<?php echo $base_url?>/details?id=<?php echo htmlspecialchars($property['id']); ?>">
                <img src="<?php echo $base_url .'/public/assets/images/'. htmlspecialchars(json_decode($property['photos'])[0]); ?>"
                    alt="<?php echo htmlspecialchars($property['type']); ?>" class="property-image">
                <h2><?php echo htmlspecialchars($property['type']); ?></h2>
                <p><?php echo htmlspecialchars($property['description']); ?></p>
                <p>Prix : <?php echo htmlspecialchars($property['loyer']); ?> Ar</p>
            </a>
        </article>
    <?php endforeach; ?>
</section>
<style>
    .product-list {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        /* 5 products per row */
        gap: 20px;
        padding: 20px;
    }

    .product-card {
        background-color: #fff;
        border-radius: 12px;
        /* Slightly rounder corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        /* Softer shadow */
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        /* Transition for shadow */
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        /* Darker shadow on hover */
    }

    .property-image {
        width: 100%;
        height: 150px;
        /* Fixed height for uniformity */
        object-fit: cover;
        /* Ensures the images cover the area */
    }

    .product-card h2 {
        font-size: 1.2em;
        margin: 10px;
        font-weight: 600;
        /* Slightly bolder font */
    }

    .product-card p {
        font-size: 1em;
        margin: 10px;
        color: #555;
    }

    .product-card a {
        text-decoration: none;
        /* Remove underline */
        color: #333;
        /* Dark color for text */
    }

    .product-card a:hover {
        color: var(--primary-color);
        /* Change color on hover */
    }

    @media (max-width: 1200px) {
        .product-list {
            grid-template-columns: repeat(3, 1fr);
            /* 3 products per row on medium screens */
        }
    }

    @media (max-width: 768px) {
        .product-list {
            grid-template-columns: repeat(2, 1fr);
            /* 2 products per row on smaller screens */
        }
    }

    @media (max-width: 480px) {
        .product-list {
            grid-template-columns: 1fr;
            /* 1 product per row on mobile */
        }
    }
</style>