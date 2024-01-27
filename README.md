# HealthWave EHR System Documentation

## 2.1 Website Design

The **HealthWave EHR system** is designed with a user-centric approach, utilizing HTML5, Bootstrap 5, and CSS. This combination ensures a contemporary and flexible user interface that’s easy to navigate. The layout is straightforward and optimized for various devices, a critical factor in healthcare settings. With its organized structure and calming colour palette, the system is conducive to efficiency in a healthcare environment.

On the functionality side, the system integrates PHPMailer for email confirmations and secure token generation, enhancing communication and security within the platform. The patient forms in the system have been thoughtfully developed to include input data fields, radio buttons, and checkboxes, allowing for comprehensive data collection for both creating and updating patient records. A significant emphasis is placed on security, particularly for user access. The system features an auto-generation function for strong passwords when new doctors register, bolstering security against unauthorized access.

Moreover, the system’s interface is carefully designed to ensure user-friendliness. All static pages are efficiently organized within a navigation bar on the homepage. This design not only simplifies the homepage layout but also provides streamlined access to various sections without overwhelming the user.

## 2.2 Technical Architecture

**Fig.1. Architectural Overview of the HealthWave EHR System, illustrating the integration between the Frontend, Backend, and Database components.**

The architecture of the HealthWave EHR System is engineered for robust data handling and operational efficiency. The flow begins at the frontend where users interact with the system through a web interface, proceeding to decision-making processes that guide whether a user needs to log in or register. After authentication, the system transitions users to the patient dashboard. Here, actions such as patient registration, record updates, profile viewing, or record deletion are managed through the backend PHP logic, interacting seamlessly with the MySQL database to retrieve or store information securely. The process is designed to ensure a smooth and logical sequence of operations, culminating in a secure logout to maintain data confidentiality.

## 2.3 Core Technologies and Database Integration:

The interface of the HealthWave EHR system is built on HTML5, ensuring a structured and compliant web presence. Bootstrap 5 is utilized to render the layout responsive, allowing the system to function seamlessly across different devices — a critical feature for healthcare providers who may switch between desktops and mobile devices. CSS is employed to apply the visual design, ensuring a professional and consistent look across the platform.

For visual cues and interactive elements, the system incorporates Font Awesome icons. These icons indicate actionable items and navigation aids within the application, such as updating patient records or accessing different sections of the patient dashboard. They are chosen for their clarity and quick loading times, which is essential for efficient use within a busy healthcare environment.

JavaScript is implemented to provide dynamic client-side features. It is responsible for validating form entries in real time, enabling asynchronous data updates without needing to refresh the page, and managing user interactions with the dashboard effectively. This results in a more responsive user experience, reducing the time medical staff spend on administrative tasks.

On the backend, PHP is tasked with server-side logic, including securing user sessions and processing patient data interactions. It works in conjunction with the MySQL database, which stores all patient information securely. MySQL’s robust structure is designed to handle complex queries quickly, ensuring data is always up-to-date and accessible when needed by the medical staff.

## 3 EHR Information System (User Manual Style)

**Fig.2. User Interaction Flowchart for the HealthWave EHR System, detailing the steps from the home page access to logout, including decision points for user registration and patient management functionalities.**

Once the desired actions are completed, the user can securely logout of the system, ensuring that all patient information remains confidential and the session is properly closed.

### User Authentication and Registration:

The registration page, developed with PHP and HTML, is designed for security and ease of use, featuring:

- **Access Control**: Restricts access to the registration form for logged-in users.
- **Form Validation**: Basic validation checks to capture accurate user details.
- **Secure Data Handling**: Employs MD5 for password hashing, with plans to transition to bcrypt.
- **User Interaction**: Confirmation emails are sent via PHPMailer, and a password suggestion tool is provided for enhanced user support.

### Doctor and Patient Functionalities:

The system offers comprehensive functionalities tailored for both doctors and patients, ensuring a smooth digital interaction. Upon accessing the "HOME PAGE," doctors are prompted to log in or register as in fig 3. Post-authentication, they are directed to a dashboard where they can manage patient information effectively as seen in fig 4.

Key features include:

- **Patient Registration**: This feature enables doctors to effortlessly register new patients in the system. Key details such as the patient’s name, age, gender, address, and contact information are easily inputted, as demonstrated in Fig. 5.
- **Patient Record Management**: This functionality facilitates the updating of existing patient records. As illustrated in Fig. 6, it allows for modifications to patient information to ensure records remain current and accurate.
- **Patient Profile Access**: Through this feature, doctors can access comprehensive patient profiles. These profiles encompass a patient’s historical medical data, ongoing treatment plans, and scheduled future appointments, providing a holistic view as depicted in Fig. 7.
- **Secure Logout**: A secure logout mechanism ensures that the session is properly terminated, safeguarding against unauthorized access.

### Operational Features and Deletion Protocol:

The operational features of our system play a pivotal role in enhancing the security and efficiency of managing patient records. These features allow for secure updates, ensuring that any alterations to patient data are conducted in a controlled and traceable manner. The deletion protocol upholds data integrity and complies with stringent security standards. Before any data deletion occurs, the system conducts a verification process to ensure stable and secure database connections. This is followed by validation of patient IDs, an essential step to prevent accidental deletion of records. Only after these checks are the DELETE statements executed, carefully and precisely removing the specified data.

## 4 Evaluation of the EHR Information System

In evaluating the Healthwave Electronic Health Record (EHR) System, our core focus was assessing various aspects integral to the healthcare professionals’ user experience, significantly streamlining patient data management, enhancing the accuracy of records, and ultimately improving patient care quality.

The average scores provided insightful data. Integration with workflow scored highly at 4.30, as did support for complex cases (4.20) and learning speed (4.15), reflecting effectiveness in aligning with professional workflow and managing intricate healthcare scenarios. Overall usability and user confidence also scored strongly at 4.00 and 4.05 each, indicating a positive reception of the interface and functions.

However, the score for the likelihood of recommending the system to a colleague was relatively lower at 3.60. This suggests some reservations among users, which might stem from specific unaddressed needs or individual user experiences. It points to a potential area for further exploration and enhancement.

To provide a more comprehensive understanding of the system’s usability, we calculated the average System Usability Scale (SUS) score for the HealthWave EHR system. The SUS score is calculated using the following mathematical formula:

For each of the ten SUS questions:

- For odd-numbered questions (1, 3, 5, 7, 9): Scoreodd = User Response −1
- For even-numbered questions (2, 4, 6, 8, 10): Scoreeven = 5 −User Response (1) (2)

Then, the sum of these adjusted scores (ranging from 0 to 4 for each question) is calculated for each respondent. The overall SUS score is obtained by multiplying this sum by 2.5, converting the score range from 0-40 to 0-100:

SUS Score = ∑ (Adjusted Scorei ×2.5) / 10 (3)

Based on this calculation, the average SUS score for the HealthWave EHR system is 52.25. This score, while above the midpoint of the scale, indicates areas where the system can be improved to enhance user satisfaction and overall experience. The SUS score provides a quantitative measure to gauge the usability of the system and serves as a valuable tool for identifying specific aspects that may benefit from further refinement.
