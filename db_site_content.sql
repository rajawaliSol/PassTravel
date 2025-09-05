-- Add site_content table
CREATE TABLE IF NOT EXISTS `site_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default About Us content
INSERT INTO `site_content` (`page`, `title`, `heading`, `content`, `image`, `updated_at`) VALUES
('about', 'About Us', '"..Explore With Us.."', '<p>KIP Tours and Trans is one of the leading service companies for Bali leisure. Headquartered in Bali – with a focus of serving inbound travellers to Indonesia – especially to BALI. Design to accommodate the service inbound Domestic and Asian Market (B2B, B2C, FIT and GIT) deliver the best service with competitive prices.</p>\r\n    <p>KIP Tours and Trans Established in 2022 founded by Cokorda Istri Indah Apsari and Kadek Sariasa. Registered under PT KIP Tours and Trans, and An active member of the association of the Indonesian Tours & Travel Agencies (ASITA) License 0634/XVII/DPP/2023.</p>\r\n    <p>KIP Tours and Trans</p>\r\n    <p>".. Explore With Us.."</p>', 'about-bg.jpg', CURRENT_TIMESTAMP);
