
<?php
require __DIR__ . '/../app/Support/DB.php';
require __DIR__ . '/../app/Models/User.php';
require __DIR__ . '/../app/Models/Music.php';

echo "Seeding database...\n";

$pdo = DB::pdo();

$adminEmail = 'lawreay1@gmail.com';
$adminId = null;
if (!User::findByEmail($adminEmail)) {
    $adminId = User::create('Admin', $adminEmail, 'password123', 'admin');
    echo "Created admin user (id={$adminId}, email={$adminEmail})\n";
} else {
    $user = User::findByEmail($adminEmail);
    $adminId = $user['id'];
    echo "Admin user already exists (id={$adminId}).\n";
}

$projects = [
    ['Welcome to Smart Music', 'welcome-to-smart-music', 'A short summary for the first project', 'Full content goes here', 'published', 1],
    ['Second Project', 'second-project', 'Another summary', 'More content', 'published', 0],
];

$stmt = $pdo->prepare("INSERT INTO projects (title, slug, summary, content, status, featured) VALUES (:title, :slug, :summary, :content, :status, :featured)");
foreach ($projects as $p) {
    $check = $pdo->prepare("SELECT id FROM projects WHERE slug = :slug LIMIT 1");
    $check->execute([':slug' => $p[1]]);
    if ($check->fetch()) {
        echo "Project {$p[1]} exists, skipping.\n";
        continue;
    }
    $stmt->execute([
        ':title' => $p[0],
        ':slug' => $p[1],
        ':summary' => $p[2],
        ':content' => $p[3],
        ':status' => $p[4],
        ':featured' => $p[5],
    ]);
    echo "Inserted project {$p[1]}\n";
}


$songs = [
    ['Halsey - Without Me', 'Halsey', 'Hopeless Fountain Kingdom', 'Electronic', 206, 'Halsey_-_Without_Me(128k).m4a'],
    ['Nasty C - See Me Now (Remix)', 'Nasty C', 'Mixed Feelings', 'Hip Hop', 218, 'Nasty_C_-_See_Me_Now__Remix__feat._MAETA(128k).m4a'],
];

$musicStmt = $pdo->prepare(
    "INSERT INTO songs (user_id, title, artist, album, genre, duration, file_path, file_size, file_type, is_public)
     VALUES (:user_id, :title, :artist, :album, :genre, :duration, :file_path, :file_size, :file_type, 1)"
);

foreach ($songs as $song) {
    $check = $pdo->prepare("SELECT id FROM songs WHERE title = :title AND user_id = :user_id LIMIT 1");
    $check->execute([':title' => $song[0], ':user_id' => $adminId]);
    if ($check->fetch()) {
        echo "Song {$song[0]} exists, skipping.\n";
        continue;
    }
    $musicStmt->execute([
        ':user_id' => $adminId,
        ':title' => $song[0],
        ':artist' => $song[1],
        ':album' => $song[2],
        ':genre' => $song[3],
        ':duration' => $song[4],
        ':file_path' => $song[5],
        ':file_size' => 0,
        ':file_type' => 'audio/mp4',
    ]);
    echo "Inserted song {$song[0]}\n";
}

echo "Seed complete.\n";
