<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-container {
            padding: 20px;
            width: 350px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.911);
            border-radius: 55px;
            margin: 5%;
            box-shadow: 11px 11px 0px 0px rgb(4, 4, 4);
            outline: 1px solid rgb(1, 1, 1);
            transition: box-shadow 0.3s ease;
        }
        .profile-container:hover {
            box-shadow: 20px 20px 0px 0px rgb(127, 195, 98);
        }
        .profile-container h2 {
            margin-bottom: 20px;
        }
        .profile-container input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .profile-container .file-input {
            margin: 10px 0;
            border-radius: 4px;
            display: block;
            width: 90%;
            height: 90px;
            border: 1px solid #ccc;
            text-align: center;
            padding: 10px;
            cursor: pointer;
        }
        .profile-container .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .profile-container button {
            width: 45%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 37px;
            cursor: pointer;
        }
        .profile-container button.delete {
            background-color: #f44336;
        }
        .profile-container button:hover {
            background-color: #45a049;
        }
        .profile-container button.delete:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

    <div class="profile-container">
        <h2>Profile</h2>
        <form action="/submit-profile" method="POST" enctype="multipart/form-data">
            <!-- Upload Photo -->
            <input type="file" name="profile_photo" class="file-input" accept="image/*" required><br>

            <!-- First Name -->
            <input type="text" name="first_name" placeholder="First Name" required><br>

            <!-- Last Name -->
            <input type="text" name="last_name" placeholder="Last Name" required><br>

            <!-- Email -->
            <input type="email" name="email" placeholder="Email" required><br>

            <!-- Buttons -->
            <div class="button-group">
                <button type="button" class="delete">Delete Profile</button>
                <button type="button">Edit Profile</button>
            </div>
        </form>
    </div>

</body>
</html>
