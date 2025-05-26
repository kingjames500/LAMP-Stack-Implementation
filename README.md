##  Setup Instructions

### Prerequisites

- PHP 8.x or higher
- MySQL 
- Apache 


### 1.  **Steps**

- Clone the repository and place it on the htdocs folder

   ```bash
   https://github.com/kingjames500/LAMP-Stack-Implementation.git
   cd LAMP-Stack-Implementation

- Create a MySQl Database:
    
     ```mysql
   CREATE DATABASE IF NOT EXISTS lamp;
   
- Import the SQL Schema:

   ```bash
      mysql -u root -p database-name <path to mysql file>
   
- Edit classes/database/connection-class.php:
     ```php
       $username = 'root';
        $password = 'your-password';
        $dbConn = new PDO('mysql:host=localhost;dbname=your-database-name', $username, $password);
   
-  Run the app:
    ```bash
    - First open xampp application.
    - Start the apache services and mysql.
    - Click the admin button on the apache   service   and you will be redirected to a browser with   your web application running or
    visit [click here to open project on browser](http://localhost)

#### 1.5 **System  Validations**
- All my form validation from the backend are found on the <name-contr.class.php> file.


### 2. **Database Schema Structure and Relationships**
   - For Database schema you can check the database.sql on the root folder of the project

   **Relationships**
   - Each judge can score many users
   - Each users can be scored by many judges
   - the scores table links judge_id and user_id and ensures unique judge-user pairings.



### 3. **Assumptions I  made**
 - The admin can manually add judges even though there is no table admin on our database
 - I assumed that judges username are unique though they are not enforced at the DB level but at the classes where the logic is
 - There is no authentication and authorization system, that includes judges, admins and users(who want to view thier scores)
 - Score values must range between 0 and 100.
 - I also assumed that UUIDs are used for primary keys instead of Id which are auto incremented, this was done to support uniqueness and future scalability.
- I assumed not to include my SQL queries on this mark down but I explained the relationships on the tables.


### 4. **Design Choices**
 - Used PHP object-Oriented Programming for better structure, readility, easier debugging, code quality and maintainability
  - Choose Bootstrap for rapid styling and responsive Layout
  - choose javascript for manipulating Document Object Models, validating and interactivity especially on the public score board
  - UUIDs for  primary keys to prevent quessworks.
   
### 5. **Future Enhancements**
  - implementing admin, judge and user authentication and authorization.
  - Add pagination and filters for user and score lists
  - Real- time score updates via Websockets
  - authentication using supabase or OAuth.
  - Implementing Third Normal Form on the database structure.
  













 




















