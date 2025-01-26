export function createDiv(){
    // 1. Fetch data from the PHP script (connection.php)
fetch('connection.php')
.then(response => response.json())  // Parse the JSON data returned by PHP
.then(records => {
    // 2. Get the container div to append the new content
    var contz = document.getElementById('contz');

    // 3. Loop through each record and create div and p elements
    records.forEach(record => {
        // Create a new div for each record
        var recordDiv = document.createElement('div');
        recordDiv.className = 'record';  // Optional: Add a class for styling

        // Create p elements for each column and set their content
        var pName = document.createElement('p');
        pName.textContent = 'Name: ' + record.name;
        
        var pIdNo = document.createElement('p');
        pIdNo.textContent = 'ID Number: ' + record.IdNo;
        
        var pRegDate = document.createElement('p');
        pRegDate.textContent = 'Registration Date: ' + record.RegDate;
        
        var pRegType = document.createElement('p');
        pRegType.textContent = 'Registration Type: ' + record.RegType;

        // Append the p elements to the record div
        recordDiv.appendChild(pName);
        recordDiv.appendChild(pIdNo);
        recordDiv.appendChild(pRegDate);
        recordDiv.appendChild(pRegType);

        // 4. Append the record div to the container (contz)
        contz.appendChild(recordDiv);
    });
})
.catch(error => console.error('Error fetching data:', error));
}