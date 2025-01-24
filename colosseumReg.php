<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colosseum Registration</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="resources/css/colosseum.css">

    <!-- Custom JS for dynamic background change (if any) -->
    <script src="resources/scriptz/theme.js" defer></script>

    <style>
        /* Resize the form container */
        .registration-form-container {
            width: 100%; /* Full width within the body */
            max-width: 600px; /* Set a maximum width for the form */
            height: 90vh; /* 90% of the body height */
            margin: 0 auto; /* Center the form horizontally */
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Make input fields a little wider for better appearance */
        .form-control {
            margin-bottom: 15px;
            width: 100%;
        }

        .form-label {
            font-size: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .registration-form-container {
                width: 90%; /* Take up more width on smaller screens */
            }
        }
    </style>
</head>
<body id="Frame">
    <div class="top-strip"></div>
    
    <!-- Registration Form Container -->
    <div class="registration-form-container">
        <h2>Registration Form</h2>
        <form id="registrationForm" method="POST" action="">

            <div class="mb-3">
                <label for="name1" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="name1" name="name1" required>
            </div>

            <div class="mb-3">
                <label for="name2" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="name2" name="name2" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="regType" class="form-label">Registration Type:</label>
                <select class="form-select" id="regType" name="regType" required>
                    <option value="Admin">Admin</option>
                    <option value="Realtor">Realtor</option>
                    <option value="Caretaker">Caretaker</option>
                    <option value="Tenant">Tenant</option>
                    <option value="Viewer">Viewer</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <!-- Custom JS -->
    <script type="module">
    import { Admin, Realtor, Caretaker, Tenant, Viewer } from './colosseumSkeleton.js';

    // This function handles the form submission
    document.getElementById("registrationForm").addEventListener("submit", async function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Collect form data
        const formData = new FormData(this);
        const regType = formData.get("regType");

        let registrationObject;

        // Create the respective object based on registration type
        switch (regType) {
            case "Admin":
                registrationObject = new Admin();
                break;
            case "Realtor":
                registrationObject = new Realtor();
                break;
            case "Caretaker":
                registrationObject = new Caretaker();
                break;
            case "Tenant":
                registrationObject = new Tenant();
                break;
            case "Viewer":
                registrationObject = new Viewer();
                break;
            default:
                alert("Invalid Registration Type");
                return;
        }

        // Set account status to "Pending"
        registrationObject.accStatus = "Pending"; // Setting account status to "Pending"

        // Populate the fields of the object
        registrationObject.populateFields(Object.fromEntries(formData));

        console.log("Registration Object:", registrationObject);

        try {
            // Add account status to the form data before sending
            formData.append("accStatus", "Pending"); // Append 'Pending' as account status

            // Send the form data to the server
            const response = await fetch("/Colosseum/resources/scriptz/register.php", {
                method: "POST",
                body: JSON.stringify(Object.fromEntries(formData.entries())),
                headers: {
                    "Content-Type": "application/json"
                }
            });

            const result = await response.json();

            // Handle the server response
            if (response.ok) {
                alert("Registration successful: " + result.message);

                // Handle successful registration here, e.g., reset the form
                this.reset();
            } else {
                alert("Registration failed: " + result.error);
            }
        } catch (error) {
            console.error("Error occurred:", error);
            alert("An error occurred while submitting the form.");
        }
    });
    </script>

</body>
</html>
