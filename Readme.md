<h1 style="text-align: center">Backend Code Base</h1>
<h5 style="text-align: center">By Dinushan Vimukthi</h5>

## API Calls

### POST

Post API call is done by using **<mark>localhost:8080/API/POST/API-CALL</mark>**  $API-CALL$ is the php file that curresponding request located.

#### Project Structure

- API
  
  - GET
    
    - GET Request Of the API Are Handled By this Directory
      - API/GET/API-CALL.php can be access by using **<mark>localhost:8080/API/GET/API-CALL</mark>**
  
  - POST
    - POST Request Of the API Are Handled By this Directory
      - API/POST/API-CALL.php can be access by using **<mark>localhost:8080/API/POST/API-CALL</mark>**

- app
  
  - Controller
    
    - Controllers for Application
  
  - Model
    
    - Models For Application
  
  - View
    
    - View For Application

- config
  
  - Migrations
    
    - Migrations For Application

- core
  
  - Core Classes (Application,Router,...) 

- database
  
  - Database Script

- public
  
  - Web Accessible Directory

- vendor
  
  - Composer Dependencies

## Core Classes
<img src="C:\xampp\htdocs\framework\assets\images\project-structure.png" alt="Project Structure" height="700" width="400">
<div>
    <ol type="1">
        <li>Application &#8594 Main Class of the Application and All the Request Handle Through this class</li>
        <li>Router &#8594 Class That Handle the Routing of The Application </li>
        <li>Request &#8594 Class That Handling the Request and Assign to Controller</li>
        <li>Session &#8594 Class That Handling <b>$_SESSION</b> Super Global Variable</li>
        <li>Response &#8594 </li>
        <li>Database &#8594 </li> 
        <li>View &#8594 </li>
        <li>Model &#8594 </li>
    </ol>
</div>
### Application
<p style="text-align: justify; padding-left: 10px;padding-right: 10px;">Application Class is the main class of the application. It is responsible for running the application and handling the request.In the public/index.php file, the application is initiated by calling the Application class And introduce the rotes to the application and register routes with controllers. Then Application Will Initiate the Classes and Resolve the Views.
</p> 


