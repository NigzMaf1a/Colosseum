// Parent Class: Record
class Record {
    constructor(RegID, Name, PhoneNo) {
        this.RegID = RegID;
        this.Name = Name;
        this.PhoneNo = PhoneNo;
    }

    // Fetch a record by ID with error handling
    async fetchById(id) {
        try {
            const response = await fetch(`connection.php?id=${id}`);
            if (!response.ok) {
                throw new Error(`Failed to fetch data: ${response.statusText}`);
            }
            const data = await response.json();
            if (!data) {
                throw new Error('No data returned from the server.');
            }
            this.populateFields(data);
        } catch (error) {
            console.error("Error fetching record:", error);
        }
    }

    // Populate fields (can be overridden by subclasses)
    populateFields(data) {
        this.RegID = data.RegID || this.RegID;
        this.Name = data.Name || this.Name;
        this.PhoneNo = data.PhoneNo || this.PhoneNo;
    }
}

// Base Class: Registration
class Registration extends Record {
    constructor(
        RegID,
        Name,
        PhoneNo,
        Email,
        Password,
        Gender,
        RegType,
        dLocation,
        PhotoPath,
        accStatus,
        lastAccessed,
        latitude,
        longitude
    ) {
        super(RegID, Name, PhoneNo);
        this.Email = Email;
        this.Password = Password;
        this.Gender = Gender;
        this.RegType = RegType;
        this.dLocation = dLocation;
        this.PhotoPath = PhotoPath;
        this.accStatus = accStatus;
        this.lastAccessed = lastAccessed;
        this.latitude = latitude;
        this.longitude = longitude;
    }

    // Populate fields with error handling
    populateFields(data) {
        super.populateFields(data);
        this.Email = data.Email || this.Email;
        this.Password = data.Password || this.Password;
        this.Gender = data.Gender || this.Gender;
        this.RegType = data.RegType || this.RegType;
        this.dLocation = data.dLocation || this.dLocation;
        this.PhotoPath = data.PhotoPath || this.PhotoPath;
        this.accStatus = data.accStatus || this.accStatus;
        this.lastAccessed = data.lastAccessed || this.lastAccessed;
        this.latitude = data.latitude || this.latitude;
        this.longitude = data.longitude || this.longitude;
    }
}

// Admin Class
class Admin extends Registration {
    constructor(...args) {
        super(...args, 'Admin');
    }
}

//Landlord Class 
class Landlord extends Registration {
    /**
     * Constructor for Landlord
     * @param {number} RegID - Unique identifier for the landlord
     * @param {string} Name - Name of the landlord
     * @param {string} PhoneNo - Phone number of the landlord
     * @param {string} Email - Email address of the landlord
     * @param {string} Password - Password for the landlord account
     * @param {string} Gender - Gender of the landlord
     * @param {string} dLocation - Default location associated with the landlord
     * @param {string} PhotoPath - Path to the landlord's profile photo
     * @param {string} accStatus - Account status of the landlord (e.g., "active", "inactive")
     * @param {string} lastAccessed - Timestamp of the landlord's last access
     * @param {number} latitude - Latitude of the landlord's primary location
     * @param {number} longitude - Longitude of the landlord's primary location
     */
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude) {
        // Call the parent constructor with Role set to 'Landlord'
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Landlord', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
    }
}

// Realtor Class
class Realtor extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Realtor', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
    }
}

// Caretaker Class
class Caretaker extends Registration {
    constructor(...args) {
        super(...args, 'Caretaker');
    }
}

// Tenant Class
class Tenant extends Registration {
    constructor(...args) {
        super(...args, 'Tenant');
    }
}

// Property Class
class Property {
    constructor(RealtorID, PropertyID, RealtorName, PropertyName, Valid) {
        this.RealtorID = RealtorID;
        this.PropertyID = PropertyID;
        this.RealtorName = RealtorName;
        this.PropertyName = PropertyName;
        this.Valid = Valid;
    }

    // Populate fields with error handling
    populateFields(data) {
        this.RealtorID = data.RealtorID || this.RealtorID;
        this.PropertyID = data.PropertyID || this.PropertyID;
        this.RealtorName = data.RealtorName || this.RealtorName;
        this.PropertyName = data.PropertyName || this.PropertyName;
        this.Valid = data.Valid || this.Valid;
    }
}

// Unit Class
class Unit extends Property {
    constructor(RealtorID, PropertyID, UnitID, UnitType, UnitName, PropertyName, RealtorName, Price, Condition, Vacant) {
        super(RealtorID, PropertyID, RealtorName, PropertyName);
        this.UnitID = UnitID;
        this.UnitType = UnitType;
        this.UnitName = UnitName;
        this.Price = Price;
        this.Condition = Condition;
        this.Vacant = Vacant;
    }

    // Populate fields with error handling
    populateFields(data) {
        super.populateFields(data);
        this.UnitID = data.UnitID || this.UnitID;
        this.UnitType = data.UnitType || this.UnitType;
        this.UnitName = data.UnitName || this.UnitName;
        this.Price = data.Price || this.Price;
        this.Condition = data.Condition || this.Condition;
        this.Vacant = data.Vacant || this.Vacant;
    }
}

// Specialized Unit Classes
class Single extends Unit {
    constructor(...args) {
        super(...args, 'Single');
    }
}
class Bedsitter extends Unit {
    constructor(...args) {
        super(...args, 'Bedsitter');
    }
}
class OneBedroom extends Unit {
    constructor(...args) {
        super(...args, 'OneBedroom');
    }
}
class TwoBedroom extends Unit {
    constructor(...args) {
        super(...args, 'TwoBedroom');
    }
}
class ThreeBedroom extends Unit {
    constructor(...args) {
        super(...args, 'ThreeBedroom');
    }
}
class AirBnB extends Unit {
    constructor(...args) {
        super(...args, 'AirBnB');
    }
}

// Deposit Class
class Deposit extends Tenant {}

// Feedback Class
class Feedback {
    constructor(FeedbackID, TenantID, TenantName, Comments, Response, Rating) {
        this.FeedbackID = FeedbackID;
        this.TenantID = TenantID;
        this.TenantName = TenantName;
        this.Comments = Comments;
        this.Response = Response;
        this.Rating = Rating;
    }

    // Populate fields with error handling
    populateFields(data) {
        this.FeedbackID = data.FeedbackID || this.FeedbackID;
        this.TenantID = data.TenantID || this.TenantID;
        this.TenantName = data.TenantName || this.TenantName;
        this.Comments = data.Comments || this.Comments;
        this.Response = data.Response || this.Response;
        this.Rating = data.Rating || this.Rating;
    }
}

// About Class
class About extends Property {
    constructor(AboutID, RealtorID, PropertyID, RealtorName, PropertyName, Detail) {
        super(RealtorID, PropertyID, RealtorName, PropertyName);
        this.AboutID = AboutID;
        this.Detail = Detail;
    }

    // Populate fields with error handling
    populateFields(data) {
        super.populateFields(data);
        this.AboutID = data.AboutID || this.AboutID;
        this.Detail = data.Detail || this.Detail;
    }
}

// Contact Class
class Contact {
    constructor(RealtorID, PhoneNo, Email, Instagram, Facebook, POBox) {
        this.RealtorID = RealtorID;
        this.PhoneNo = PhoneNo;
        this.Email = Email;
        this.Instagram = Instagram;
        this.Facebook = Facebook;
        this.POBox = POBox;
    }

    // Populate fields with error handling
    populateFields(data) {
        this.RealtorID = data.RealtorID || this.RealtorID;
        this.PhoneNo = data.PhoneNo || this.PhoneNo;
        this.Email = data.Email || this.Email;
        this.Instagram = data.Instagram || this.Instagram;
        this.Facebook = data.Facebook || this.Facebook;
        this.POBox = data.POBox || this.POBox;
    }
}

// Export all classes
export {
    Record,
    Registration,
    Admin,
    Realtor,
    Caretaker,
    Tenant,
    Property,
    Unit,
    Deposit,
    Feedback,
    About,
    Contact,
    Single,
    Bedsitter,
    OneBedroom,
    TwoBedroom,
    ThreeBedroom,
    AirBnB
};
