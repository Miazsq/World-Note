<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World Note</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="glass-container">
        <h1>
            <i class="fa fa-globe" aria-hidden="true"></i>
            World Note
        </h1>
        <p><em>Pin your thoughts</em></p>
    </div>
    
    <div id="map"></div>
    
    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa fa-pencil" aria-hidden="true"></i> Add a Note</h3>
                <button class="close-btn" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body">
                <textarea id="message" placeholder="Share your thoughts..."></textarea>
            </div>
            <div class="modal-footer">
                <div class="color-picker">
                    <span class="color-circle yellow" onclick="selectColor('yellow')"></span>
                    <span class="color-circle blue" onclick="selectColor('blue')"></span>
                    <span class="color-circle red" onclick="selectColor('red')"></span>
                    <span class="color-circle green" onclick="selectColor('green')"></span>
                    <span class="color-circle purple" onclick="selectColor('purple')"></span>
                    <span class="color-circle orange" onclick="selectColor('orange')"></span>
                </div>
                <button type="button" class="post-btn" onclick="savePin()">Post</button>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="map.js"></script>
    
</body>
</html>