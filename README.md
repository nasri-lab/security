# Security Lab Project

This project is dedicated to conducting security testing and fixing vulnerabilities related to the OWASP Top 10 vulnerabilities.

## Purpose

The primary objective of this project is to provide a hands-on environment for testing and understanding common security vulnerabilities outlined in the OWASP Top 10 list. By identifying, exploiting, and fixing these vulnerabilities, participants can gain practical experience in secure application development and enhance their understanding of cybersecurity concepts.

## Features

- **Vulnerability Testing**: The project includes test cases and scenarios for assessing vulnerabilities related to the OWASP Top 10 list, including SQL injection, broken access control, cross-site scripting (XSS), and more.
  
- **Fixing Vulnerabilities**: Participants are encouraged to analyze and fix identified vulnerabilities using best practices and secure coding techniques. Sample code snippets and guidelines may be provided to assist with the remediation process.

- **Educational Resources**: Supplementary educational materials, tutorials, and resources may be provided to support participants in understanding the underlying principles of each vulnerability and how to effectively mitigate them.

## Getting Started

To get started with the security lab project, follow these steps:

1. Clone the project repository from GitHub.
2. Customize the **docker-compose.yml** file, particularly the following line:
    
	```
	/home/nasri/www/sql-injection:/var/www/html
	```
	Replace `/home/nasri/www/sql-injection` with the directory path where you have stored the source code on your local machine.
3. Run the project and proceed with the labs (refer to the **Lab** section for details).


## Labs

- **[Lab 1: SQL Injection](https://github.com/nasri-lab/security/blob/main/labs/lab1-en.md)**: Learn how to identify and exploit SQL injection vulnerabilities in web applications.

- **[Lab 2: Broken Access Control](https://github.com/nasri-lab/security/blob/main/labs/lab2-en.md)**: Learn how to broke and hack access to unauthorized resources.

- **[Lab 3: Cryptographic Failures](https://github.com/nasri-lab/security/blob/main/labs/lab3-en.md)**: Learn how to identify and exploit Cryptographic Failures.

## Contribution Guidelines

Contributions to the security lab project are welcome and encouraged. If you have identified new test cases, vulnerabilities, or improvements to existing code, feel free to submit a pull request with your changes.

When contributing to this project, please adhere to the following guidelines:

- Follow best practices for secure coding and vulnerability remediation.
- Clearly document any changes or additions made to the project.
- Test your changes thoroughly to ensure they do not introduce new vulnerabilities or regressions.
- Respect the project's code of conduct and contribute in a constructive manner.

## Contact Information

For any corrections or suggestions, please contact Mohammed Nasri at [mohammed.nasri@gmail.com](mailto:mohammed.nasri@gmail.com).

## License

This project is licensed under the [MIT License](LICENSE).
