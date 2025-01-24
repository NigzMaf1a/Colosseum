// regObject.js

// Import the classes from colosseumSkeleton.js and the logAct.js script
import { Admin, Realtor, Caretaker, Tenant, Deposit, Feedback, Property, Unit, Contact } from './colosseumSkeleton.js';
import { updateLastAccessed, updateAccountStatus } from './logAct.js';

// Object to store current user session (after login)
let currentUser = null;

// Utility function to create a new user object based on the registration type
function createUserObject(regID, name, phoneNo, email, password, gender, regType, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude) {
    switch (regType) {
        case 'Admin':
            return new Admin(regID, name, phoneNo, email, password, gender, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude);
        case 'Realtor':
            return new Realtor(regID, name, phoneNo, email, password, gender, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude);
        case 'Caretaker':
            return new Caretaker(regID, name, phoneNo, email, password, gender, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude);
        case 'Tenant':
            return new Tenant(regID, name, phoneNo, email, password, gender, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude);
        default:
            console.error('Unknown registration type:', regType);
            return null;
    }
}

// Function to handle registration - create a user object after successful registration
export function handleRegistration(regID, name, phoneNo, email, password, gender, regType, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude) {
    currentUser = createUserObject(regID, name, phoneNo, email, password, gender, regType, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude);
    if (currentUser) {
        console.log(`${regType} registration successful. User object created:`, currentUser);
    } else {
        console.error('Error creating user object.');
    }
}

// Function to handle login - identify the user object after successful login
export function handleLogin(regID, name, phoneNo, email, password, gender, regType, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude) {
    currentUser = createUserObject(regID, name, phoneNo, email, password, gender, regType, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude);
    if (currentUser) {
        console.log(`${regType} login successful. User object identified:`, currentUser);
        // Update the last accessed time
        updateLastAccessed(regID);
    } else {
        console.error('Error identifying user object.');
    }
}

// Function to handle logout - update changes and transactions
export function handleLogout() {
    if (currentUser) {
        // Perform any necessary transactions or updates before logging out
        console.log('Logging out user. Updating changes for consistency...');
        updateAccountStatus(currentUser.RegID);
        currentUser = null;  // Reset the currentUser object on logout
    } else {
        console.error('No user is currently logged in.');
    }
}

// Function to update the user object based on changes to their data in the database
export function updateUserObject(regID, name, phoneNo, email, password, gender, regType, dLocation, photoPath, accStatus, lastAccessed, latitude, longitude) {
    if (currentUser && currentUser.RegID === regID) {
        currentUser.populateFields({
            RegID: regID,
            Name: name,
            PhoneNo: phoneNo,
            Email: email,
            Password: password,
            Gender: gender,
            RegType: regType,
            dLocation: dLocation,
            PhotoPath: photoPath,
            accStatus: accStatus,
            lastAccessed: lastAccessed,
            latitude: latitude,
            longitude: longitude
        });
        console.log('User object updated:', currentUser);
    } else {
        console.error('No matching user object found to update.');
    }
}

// Export the current user for access across other modules
export { currentUser };
