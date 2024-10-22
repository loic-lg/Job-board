-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 22 oct. 2024 à 09:45
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `job_board`
--

-- --------------------------------------------------------

--
-- Structure de la table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `wages` int(11) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `working_time` varchar(255) DEFAULT NULL,
  `full_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `advertisements`
--

INSERT INTO `advertisements` (`id`, `title`, `short_description`, `company_id`, `created_at`, `updated_at`, `wages`, `place`, `working_time`, `full_description`) VALUES
(1, 'Data Scientistiiii', 'We are hiring a data scientist to analyze large datasets.', 100001, '2024-10-08 12:57:00', '2024-10-15 20:36:08', 187, 'Lyon', 'CDI', 'Data Scientists analyze complex datasets to derive actionable insights. They build predictive models using machine learning, clean and structure data, and help organizations make data-driven decisions. Collaborating closely with stakeholders, they solve critical business challenges by identifying patterns and trends. Proficiency in statistical analysis, programming languages like Python or R, and a strong understanding of data visualization tools are essential. Data Scientists play a pivotal role in optimizing business strategies and enhancing overall efficiency through data analytics.'),
(2, 'Marketing Manager', 'We are seeking a skilled marketing manager to oversee our marketing campaigns. Responsibilities include developing targeted marketing strategies, managing social media accounts, and analyzing market trends.', 100001, '2024-10-08 12:51:50', '2024-10-15 20:33:00', 14, 'Strasbourg', 'Alternance', 'Marketing Managers are responsible for developing and implementing marketing strategies to promote products or services. They oversee campaigns, analyze market trends, and manage advertising efforts to reach target audiences. Working with creative teams, they ensure consistent brand messaging and monitor campaign performance to optimize results. Strong leadership, analytical skills, and a deep understanding of customer behavior are crucial for this role. Marketing Managers play a key role in driving brand awareness and increasing market share.'),
(3, 'Sales Representative', 'We are hiring a sales representative to represent our company at trade shows and customer events. Responsibilities include building relationships with customers, demonstrating our products, and closing deals.', 100001, '2024-10-08 12:51:50', '2024-10-15 20:33:13', 16, 'Nancy', 'CDD', 'Sales Representatives sell products or services to potential clients, meet sales targets, and build lasting customer relationships. They identify leads, present product benefits, negotiate contracts, and close deals. Skilled in communication and persuasion, they ensure customer satisfaction and generate repeat business. Sales Representatives work closely with marketing and product teams to understand the offerings and provide tailored solutions to clients is needs. Their success is often measured by their ability to meet or exceed sales quotas.'),
(4, 'Data Scientist', 'We are hiring a data scientist to analyze large datasets.', 100002, '2024-10-08 12:57:00', '2024-10-15 20:33:08', 18, 'Lyon', 'CDI', 'Data Scientists analyze complex datasets to derive actionable insights. They build predictive models using machine learning, clean and structure data, and help organizations make data-driven decisions. Collaborating closely with stakeholders, they solve critical business challenges by identifying patterns and trends. Proficiency in statistical analysis, programming languages like Python or R, and a strong understanding of data visualization tools are essential. Data Scientists play a pivotal role in optimizing business strategies and enhancing overall efficiency through data analytics.'),
(5, 'UX Designer', 'Looking for a creative UX designer for our web platform.', 100001, '2024-10-09 12:51:50', '2024-10-15 20:33:18', 12, 'Bordeaux', 'CDD', 'UX Designers focus on creating intuitive and user-friendly digital experiences. They conduct user research, develop wireframes, and collaborate with developers to implement design solutions that meet user needs. By understanding user behavior, they optimize the usability and accessibility of websites, apps, and other digital products. UX Designers play a crucial role in enhancing customer satisfaction by ensuring that interactions with the product are seamless and enjoyable. Their work directly impacts product engagement and user retention.'),
(6, 'Data Scientist', 'We are hiring a data scientist to analyze large datasets.', 100002, '2024-10-08 12:57:00', '2024-10-15 20:33:24', 18, 'Lyon', 'CDI', 'Data Scientists analyze complex datasets to derive actionable insights. They build predictive models using machine learning, clean and structure data, and help organizations make data-driven decisions. Collaborating closely with stakeholders, they solve critical business challenges by identifying patterns and trends. Proficiency in statistical analysis, programming languages like Python or R, and a strong understanding of data visualization tools are essential. Data Scientists play a pivotal role in optimizing business strategies and enhancing overall efficiency through data analytics.'),
(7, 'UX Designer', 'Looking for a creative UX designer for our web platform.', 100001, '2024-10-09 12:51:50', '2024-10-15 20:33:29', 12, 'Bordeaux', 'CDD', 'UX Designers focus on creating intuitive and user-friendly digital experiences. They conduct user research, develop wireframes, and collaborate with developers to implement design solutions that meet user needs. By understanding user behavior, they optimize the usability and accessibility of websites, apps, and other digital products. UX Designers play a crucial role in enhancing customer satisfaction by ensuring that interactions with the product are seamless and enjoyable. Their work directly impacts product engagement and user retention.'),
(8, 'Product Manager', 'Hiring a product manager to lead our product teams.', 100002, '2024-10-09 12:51:50', '2024-10-15 20:33:34', 20, 'Paris', 'CDI', 'Product Managers oversee the development and lifecycle of a product, from conception to launch. They work cross-functionally with engineering, marketing, and sales teams to ensure products meet business goals and market needs. Product Managers define product vision, prioritize features, and coordinate the development process. They are responsible for ensuring that the product delivers value to users while aligning with the company’s objectives. Strong communication and strategic thinking are vital in this role.'),
(9, 'DevOps Engineer', 'Looking for a DevOps engineer to maintain cloud infrastructure.', 100002, '2024-10-09 12:51:50', '2024-10-15 20:33:39', 17, 'Toulouse', 'CDI', 'DevOps Engineers bridge the gap between development and operations teams, ensuring efficient software deployment. They automate workflows, manage infrastructure, and optimize the continuous integration and delivery (CI/CD) process. Their work involves building tools to improve system reliability and scalability, monitoring performance, and responding to system failures. Proficient in scripting languages, cloud platforms, and automation tools, DevOps Engineers play a critical role in accelerating development cycles and maintaining stable production environments.'),
(10, 'Technical Writer', 'Hiring a technical writer to document our software processes.', 100001, '2024-10-09 12:51:50', '2024-10-15 20:33:45', 11, 'Nice', 'Alternance', 'Technical Writers produce clear, user-friendly documentation for complex technical processes and products. They create manuals, guides, FAQs, and other content that helps users understand and navigate software, hardware, or technical workflows. Strong communication skills and the ability to translate technical jargon into accessible language are key. Working closely with engineers, they ensure that documentation is accurate and up-to-date. Their work ensures that users can effectively use technology without confusion.'),
(11, 'HR Specialist', 'We are seeking an HR specialist to manage recruitment.', 100001, '2024-10-09 12:51:50', '2024-10-15 20:33:50', 15, 'Lille', 'CDI', 'HR Specialists manage various human resources functions, including recruitment, employee relations, benefits administration, and compliance with labor laws. They work closely with management to align HR strategies with business goals, ensuring a productive and compliant workforce. Their responsibilities also include onboarding new hires, resolving employee issues, and implementing training programs. Strong interpersonal skills, knowledge of HR regulations, and a focus on employee satisfaction are crucial for success in this role.'),
(12, 'Sales Manager', 'Looking for a sales manager to lead our sales team.', 100002, '2024-10-09 12:51:50', '2024-10-15 20:33:55', 22, 'Nantes', 'CDI', 'Sales Managers lead sales teams, set sales targets, and develop strategies to achieve business objectives. They monitor team performance, analyze sales data, and provide coaching to improve individual performance. Sales Managers also maintain relationships with key clients and ensure that customer satisfaction remains high. A combination of leadership, analytical skills, and industry knowledge is essential for success. They are responsible for driving revenue growth and ensuring that the sales team meets or exceeds goals.'),
(13, 'Frontend Developer', 'We are hiring a frontend developer for our e-commerce platform.', 100001, '2024-10-09 12:51:50', '2024-10-15 20:34:00', 16, 'Marseille', 'CDD', 'Frontend Developers build and maintain the user interface of websites and applications. They work with HTML, CSS, and JavaScript to create responsive and visually appealing designs that enhance user experience. By ensuring that websites are accessible across different devices and browsers, Frontend Developers play a key role in creating seamless digital interactions. Collaboration with UX designers and backend developers is crucial to implement features effectively. They focus on performance optimization and delivering interactive, user-friendly websites.'),
(14, 'Backend Developer', 'Looking for a backend developer to optimize our systems.', 100002, '2024-10-09 12:51:50', '2024-10-15 20:34:04', 19, 'Paris', 'CDI', 'Backend Developers manage the server-side logic of web applications, ensuring seamless data flow and functionality. They work with databases, APIs, and server configurations to support the frontend and ensure smooth operations. Proficient in programming languages like Python, Ruby, or Java, Backend Developers handle data storage, security, and server management. Their work ensures that web applications are robust, scalable, and able to handle large amounts of data efficiently.'),
(15, 'IT Support Specialist', 'Hiring an IT support specialist to assist with technical issues.', 100002, '2024-10-09 12:51:50', '2024-10-15 20:34:09', 14, 'Lyon', 'Alternance', 'IT Support Specialists provide technical assistance and troubleshoot hardware, software, and network issues. They assist users with IT-related problems, set up new systems, and ensure that all technological operations run smoothly. They often work on resolving tickets, updating software, and performing routine system maintenance. Excellent problem-solving skills and a strong knowledge of IT infrastructure are essential. IT Support Specialists are key in maintaining productivity by ensuring minimal downtime for users.'),
(16, 'Graphic Designer', 'We are seeking a graphic designer to enhance our visual content.', 100001, '2024-10-09 12:51:50', '2024-10-15 20:34:14', 10, 'Rennes', 'CDD', 'Graphic Designers create visually compelling designs for branding, advertising, websites, and print materials. They work with design software like Adobe Illustrator and Photoshop to produce logos, illustrations, and layouts that align with the brand’s identity. Creativity and an eye for detail are crucial in this role. Graphic Designers collaborate with marketing teams to ensure visual consistency across all platforms, helping to communicate messages effectively through visuals.'),
(17, 'Marketing Analyst', 'Looking for a marketing analyst to track campaign performance.', 100002, '2024-10-09 12:51:50', '2024-10-15 20:34:18', 18, 'Strasbourg', 'CDI', 'Marketing Analysts collect and analyze data related to marketing campaigns, consumer behavior, and market trends. They provide actionable insights to optimize marketing strategies and improve ROI. Proficient in data analysis tools, they help businesses understand which campaigns are effective and where improvements can be made. Their work is essential in guiding marketing decisions and maximizing the impact of promotional activities.'),
(18, 'Cloud Architect', 'We are hiring a cloud architect to design scalable solutions.', 100002, '2024-10-09 12:51:50', '2024-10-15 20:34:23', 23, 'Paris', 'CDI', 'Cloud Architects design and manage cloud infrastructure solutions that ensure scalability, security, and cost-efficiency for organizations. They integrate cloud services, manage resources, and design disaster recovery plans. Proficient in cloud platforms like AWS, Azure, or Google Cloud, they help companies transition to cloud environments while ensuring optimal performance. Their work is crucial in modernizing IT infrastructure and supporting business growth through cloud solutions.'),
(19, 'SEO Specialist', 'Hiring an SEO specialist to optimize our website rankings.', 100002, '2024-10-09 12:51:50', '2024-10-15 20:34:38', 13, 'Bordeaux', 'Alternance', 'SEO Specialists optimize websites to rank higher on search engines like Google. They use keywords, improve site structure, and create content strategies that align with search engine algorithms. Their work involves continuous monitoring of search engine trends and performance analytics to enhance visibility and drive traffic. By improving a site’s organic ranking, SEO Specialists play a vital role in increasing brand exposure and attracting potential customers online.'),
(20, 'Cybersecurity Expert', 'Looking for a cybersecurity expert to protect our infrastructure.', 100002, '2024-10-09 12:51:50', '2024-10-15 20:34:28', 25, 'Nice', 'CDI', 'Cybersecurity Experts protect an organization’s digital assets from cyber threats such as hacking, phishing, and malware attacks. They identify vulnerabilities, implement security measures, and respond to security breaches to safeguard sensitive data. Their work includes setting up firewalls, encryption, and intrusion detection systems. With a focus on prevention, Cybersecurity Experts ensure that an organization is data remains secure in an increasingly digital world.'),
(51, '6161', '165161', 100002, '2024-10-15 17:32:15', '2024-10-15 20:34:32', 61, '61515', 'CDI', '65161'),
(56, 'web dev ', 'courteert', 100002, '2024-10-16 13:53:06', '2024-10-16 13:54:05', 20, 'Strasbourg ', 'CDI', 'COMPL7TE com^plètesbbb'),
(58, 'yfv', 'tyfvf', 100003, '2024-10-16 15:12:04', '2024-10-16 15:12:16', 6757, 'yugyu', 'CDD', 'tyfv'),
(59, 'compagnie 47', 'ok', 100002, '2024-10-18 11:37:27', '2024-10-18 11:37:27', 1234, 'Strasbourg ', 'Stage', 'ok');

-- --------------------------------------------------------

--
-- Structure de la table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `email`, `password`) VALUES
(100001, 'Entreprise', '123 New St', 'new@new.com', '123'),
(100002, '45412345', '454', '47@47.com', '47'),
(100003, 'OK', 'ok', 'ok@ok.com', 'ok');

-- --------------------------------------------------------

--
-- Structure de la table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `advertisement_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL,
  `emails_sent` text DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `job_applications`
--

INSERT INTO `job_applications` (`id`, `advertisement_id`, `person_id`, `application_date`, `status`, `emails_sent`, `message`) VALUES
(2, 2, 2, '2024-10-08 12:51:50', 'Approved', NULL, NULL),
(3, 3, 3, '2024-10-08 12:51:50', 'Rejected', NULL, NULL),
(5, 3, 5, '2024-10-18 10:56:03', 'Pending', NULL, NULL),
(7, 5, 5, '2024-10-18 10:57:37', 'Pending', NULL, NULL),
(9, 2, 5, '2024-10-18 11:03:15', 'Pending', NULL, NULL),
(14, 2, 4, '2024-10-18 11:32:55', 'Pending', NULL, NULL),
(18, 2, 1, '2024-10-18 11:33:35', 'Pending', NULL, NULL),
(21, 11, 4, '2024-10-18 14:45:56', 'Pending', NULL, NULL),
(22, 1, 4, '2024-10-19 14:50:32', 'Pending', NULL, NULL),
(26, 59, 4, '2024-10-19 15:49:33', 'Pending', NULL, 'hygyuguy'),
(27, 1, 1, '2024-10-19 19:35:14', 'Pending', NULL, 'dfdhfjh');

-- --------------------------------------------------------

--
-- Structure de la table `people`
--

CREATE TABLE `people` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` text NOT NULL,
  `role` varchar(50) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `people`
--

INSERT INTO `people` (`id`, `username`, `lastname`, `email`, `mdp`, `role`, `file_path`) VALUES
(1, 'tiger', 'tiger', 'tiger@tiger.fr', 'tiger', 'Admin', NULL),
(2, 'Jane Smith', '', 'jane@example.com', '555-5678', 'Applicant', NULL),
(3, 'ne fonction pas ', 'admin ', 'admin@admin.fr\r\n', 'password', 'Admin', NULL),
(4, 'loic', 'le gal', 'legal.loic@gmail.com', 'epitech', 'Applicant', NULL),
(5, 'loic', '5', 'legal.loic1@gmail.com', 'loic5', 'Applicant', NULL),
(6, 'le gal', '', 'test@gmail.com', 'loic', 'Applicant', NULL),
(8, 'ours', 'ours', 'test2@gmail.com', 'ours', 'Applicant', NULL),
(11, 'test1.1', 'test1', '0toutouomyountebo0@gmail.com', 'Arthuryoutebo09.', 'Applicant', NULL),
(12, 'aaa', 'aaa', 'kljio@klhjoi.com', 'aa', 'Applicant', NULL),
(13, 'test', '', 'test@test.ld', '12', 'Applicant', NULL),
(14, '1561', '1561', '1561@5465', '45', 'Applicant', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Index pour la table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advertisement_id` (`advertisement_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Index pour la table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100005;

--
-- AUTO_INCREMENT pour la table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `advertisements`
--
ALTER TABLE `advertisements`
  ADD CONSTRAINT `advertisements_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Contraintes pour la table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `fk_person_id` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
