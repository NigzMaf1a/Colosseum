<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Colosseum</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="resources/css/colosseum.css">

    <!-- Custom JS for dynamic background change (if any) -->
    <script src="resources/scriptz/theme.js" defer></script>

    <style>
        /* Fixed top strip */
        .top-strip {
            width: 100%;
            height: 100px;
            background-color: #333;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
        }

        /* Centered login form container */
        .login-form-container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto 0;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .form-label {
            font-size: 1rem;
        }

        .form-control {
            margin-bottom: 15px;
        }

        /* Make sure the login form is centered below the top strip */
        body {
            margin-top: 100px; /* To make space for the fixed top strip */
        }
    </style>
</head>
<body id="Frame">
    <div class="top-strip"></div>

    <!-- Login Form Container -->
    <div class="login-form-container">
        <h2 class="text-center">Login</h2>
        <form id="loginForm" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" id="logSubut" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <!-- Custom JS -->
    <script type="module">
        import { Admin, Realtor, Caretaker, Tenant, Viewer } from './colosseumSkeleton.js';
        import { logInUser } from './logAct.js';

        document.getElementById("loginForm").addEventListener("submit", async function (e) {
            e.preventDefault();

            // Collect form data
            const formData = new FormData(this);
            const email = formData.get("email");
            const password = formData.get("password");

            // Check if email and password exist in the database and verify accStatus
            try {
                // Send login credentials to backend (use userLogin.php)
                const response = await fetch("/Colosseum/resources/scriptz/userLogin.php", {
                    method: "POST",
                    body: JSON.stringify({ email, password }),
                    headers: {
                        "Content-Type": "application/json"
                    }
                });

                const result = await response.json();

                if (response.ok && result.status === "success") {
                    const { accStatus, regType, userData } = result;

                    if (accStatus === "Approved") {
                        let userObject;

                        // Create the user object based on the registration type
                        switch (regType) {
                            case "Admin":
                                userObject = new Admin();
                                break;
                            case "Realtor":
                                userObject = new Realtor();
                                break;
                            case "Caretaker":
                                userObject = new Caretaker();
                                break;
                            case "Tenant":
                                userObject = new Tenant();
                                break;
                            case "Viewer":
                                userObject = new Viewer();
                                break;
                            default:
                                alert("Unknown registration type.");
                                return;
                        }

                        // Populate the object with user data
                        userObject.populateFields(userData);

                        // Use logAct.js for further login actions, e.g., logging actions or setting session data
                        logInUser(userObject);

                        // Redirect to the appropriate dashboard based on user type
                        switch (regType) {
                            case "Admin":
                                window.location.href = "./admin/adminDash.php";
                                break;
                            case "Realtor":
                                window.location.href = "./realtor/realDash.php";
                                break;
                            case "Caretaker":
                                window.location.href = "./caretaker/careDash.php";
                                break;
                            case "Tenant":
                                window.location.href = "./tenant/tenDash.php";
                                break;
                            case "Viewer":
                                window.location.href = "./viewer/viewDash.php";
                                break;
                            default:
                                alert("Redirect failed. Please try again.");
                        }
                    } else {
                        alert("Your account is not approved yet.");
                    }
                } else {
                    alert(result.error || "Invalid login credentials.");
                }
            } catch (error) {
                console.error("Error occurred:", error);
                alert("An error occurred while logging in.");
            }
        });
    </script>
</body>
</html>
