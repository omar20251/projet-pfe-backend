<?php
// config/services.php - Ajouter cette section
return [
    // ... autres services
    
    'groq' => [
        'api_key' => env('GROQ_API_KEY'),
    ],
];

