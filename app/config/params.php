<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    
    'seedUserPassword' => getenv('SEED_USER_PASSWORD'),
    'seedImagesUrl' => 'images/seed/',
    'seedUsers' => getenv('SEED_USERS'),
    'seedAlbumsPerUser' => getenv('SEED_ALBUMS_PER_USER'),
    'seedPhotosPerAlbum' => getenv('SEED_PHOTOS_PER_ALBUM')
];
