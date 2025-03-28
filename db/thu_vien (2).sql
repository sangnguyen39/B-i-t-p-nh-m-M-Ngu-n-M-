-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th1 21, 2025 lúc 10:27 AM
-- Phiên bản máy phục vụ: 9.1.0
-- Phiên bản PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `thu_vien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `book_id` int NOT NULL AUTO_INCREMENT,
  `book_title` varchar(100) NOT NULL,
  `category_id` int NOT NULL,
  `author` varchar(50) NOT NULL,
  `publication_year` year DEFAULT NULL,
  `nha_xuat_ban` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_anh_bia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_quantity` int DEFAULT '0',
  `available_quantity` int DEFAULT '0',
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `book`
--

INSERT INTO `book` (`book_id`, `book_title`, `category_id`, `author`, `publication_year`, `nha_xuat_ban`, `file_anh_bia`, `mo_ta`, `total_quantity`, `available_quantity`) VALUES
(1, 'Cuốn theo chiều gió', 1, 'Margaret Mitchell', '1936', 'Nhà xuất bản Trẻ', '1.jpg', 'Một câu chuyện tình yêu đầy cảm xúc diễn ra trong bối cảnh chiến tranh Nam - Bắc Mỹ, với nhân vật chính là Scarlett O\'Hara và những biến động lớn trong cuộc đời cô.', 10, 10),
(2, 'Những người khốn khổ', 1, 'Victor Hugo', '1986', 'NXB Hội Nhà Văn', '2.jpg', 'Tác phẩm kinh điển về sự đau khổ, lòng nhân ái và cuộc đấu tranh cho công lý, tập trung vào cuộc đời của Jean Valjean và những mâu thuẫn xã hội thời bấy giờ.', 15, 11),
(3, 'Harry Potter và Hòn đá phù thủy', 1, 'J.K. Rowling', '1997', 'Nhà xuất bản Trẻ', '3.jpg', 'Câu chuyện mở đầu về cậu bé phù thủy Harry Potter, từ việc khám phá thân phận đến những cuộc phiêu lưu đầu tiên tại trường Hogwarts, nơi cậu đối mặt với thế lực hắc ám.', 20, 20),
(4, 'Hoàng tử bé', 1, 'Antoine de Saint-Exupéry', '1943', 'NXB Hội Nhà Văn', '4.jpg', 'Một câu chuyện triết lý sâu sắc qua hành trình của một hoàng tử nhỏ đi khám phá các hành tinh khác nhau, đặt câu hỏi về tình yêu, tình bạn và ý nghĩa của cuộc sống.', 12, 12),
(5, 'Sherlock Holmes: Dấu bộ tứ', 1, 'Arthur Conan Doyle', '1986', 'NXB Hội Nhà Văn', '5.jpg', 'Một vụ án bí ẩn liên quan đến bốn người đồng phạm và kho báu Ấn Độ, với sự điều tra sắc bén của thám tử Sherlock Holmes.', 8, 8),
(6, 'Nguồn gốc các loài', 2, 'Charles Darwin', '1996', 'NXB Thế Giới', '6.jpg', 'Tác phẩm đột phá trình bày lý thuyết tiến hóa qua chọn lọc tự nhiên, giải thích nguồn gốc và sự đa dạng của các loài sinh vật trên Trái Đất.', 10, 10),
(7, 'Lập trình Python căn bản', 2, 'Guido van Rossum', '2001', 'NXB Hà Nội', '7.jpg', 'Hướng dẫn chi tiết về các khái niệm cơ bản của Python, giúp người đọc bắt đầu hành trình lập trình một cách dễ dàng và hiệu quả.', 20, 17),
(8, 'Trí tuệ nhân tạo: Từ cơ bản đến nâng cao', 2, 'Stuart Russell', '2016', 'NXB Hà Nội', '8.jpg', 'Khám phá các nguyên lý nền tảng, thuật toán và ứng dụng thực tế của trí tuệ nhân tạo trong nhiều lĩnh vực khác nhau.', 15, 15),
(9, 'Hóa học: Cơ bản và ứng dụng', 2, 'John Kotz', '2005', 'NXB Hà Nội', '9.jpg', 'Giới thiệu các nguyên tắc cơ bản của hóa học cùng các ứng dụng thực tế, từ phản ứng hóa học đến các hợp chất hữu cơ và vô cơ.', 10, 10),
(10, 'Kỹ thuật phần mềm hiện đại', 2, 'Ian Sommerville', '2015', 'NXB Hà Nội', '10.jpg', 'Tài liệu chuyên sâu về các phương pháp, quy trình và công cụ trong phát triển phần mềm hiện đại, từ lập kế hoạch đến triển khai.', 8, 8),
(11, 'Chí Phèo', 3, 'Nam Cao', '1941', 'Nhà xuất bản Văn học', '11.jpg', 'Bi kịch của một người nông dân bị tha hóa bởi xã hội phong kiến, phản ánh những bất công và mâu thuẫn trong xã hội Việt Nam thời bấy giờ.', 12, 12),
(12, 'Truyện Kiều', 3, 'Nguyễn Du', '1997', 'Nhà xuất bản Giáo dục', '12.jpg', 'Kiệt tác thơ ca của Việt Nam kể về cuộc đời đau khổ của nàng Kiều, phản ánh xã hội phong kiến đầy bất công.', 15, 15),
(13, 'Vợ nhặt', 3, 'Kim Lân', '1955', 'Nhà xuất bản Hội Nhà Văn', '13.jpg', 'Câu chuyện cảm động về tình người trong nạn đói, khi con người vẫn tìm thấy hy vọng và tình yêu giữa nghịch cảnh.', 10, 10),
(14, 'Tắt đèn', 3, 'Ngô Tất Tố', '1939', 'Nhà xuất bản Văn học', '14.jpg', 'Tác phẩm phản ánh sự áp bức của chế độ thực dân và phong kiến, qua bi kịch của chị Dậu và gia đình cô.', 10, 10),
(15, 'Đoạn trường tân thanh', 3, 'Nguyễn Du', '1999', 'Nhà xuất bản Văn hóa', '15.jpg', 'Một bản dịch và chú giải sâu sắc về Truyện Kiều, mang đến cái nhìn toàn diện về tác phẩm kinh điển này.', 8, 8),
(16, 'Tư bản luận', 4, 'Karl Marx', '2000', 'Nhà xuất bản Chính trị Quốc gia', '16.jpg', 'Phân tích sâu sắc về kinh tế chính trị và các mâu thuẫn của chủ nghĩa tư bản, tác phẩm kinh điển trong lĩnh vực triết học và kinh tế học.', 5, 5),
(17, 'Quốc gia khởi nghiệp', 4, 'Dan Senor', '2009', 'Twelve', '17.jpg', 'Câu chuyện thành công của Israel trong việc trở thành quốc gia dẫn đầu về đổi mới và khởi nghiệp, với những bài học quý giá cho các quốc gia khác.', 15, 15),
(18, 'Cha giàu cha nghèo', 4, 'Robert Kiyosaki', '1997', 'NXB Thế Giới', '18.jpg', 'Những bài học tài chính cá nhân và cách tư duy về tiền bạc qua hai hình mẫu người cha, giúp độc giả quản lý tài chính hiệu quả.', 20, 20),
(19, 'Kinh tế học vi mô', 4, 'Paul Krugman', '2018', 'NXB Cengage Learning', '19.jpg', 'Giới thiệu các nguyên lý cơ bản của kinh tế học vi mô, giúp người đọc hiểu rõ hơn về hành vi kinh tế của các cá nhân và doanh nghiệp.', 12, 12),
(20, 'Kinh tế học vĩ mô', 4, 'Paul Krugman', '2019', 'NXB Cengage Learning', '20.jpg', 'Tổng quan về các nguyên lý kinh tế học vĩ mô, bao gồm các yếu tố ảnh hưởng đến tăng trưởng kinh tế và chính sách tài khóa.', 10, 10),
(21, 'Nhà đầu tư thông minh', 5, 'Benjamin Graham', '1949', 'NXB Thế Giới', '21.jpg', 'Cuốn sách kinh điển về đầu tư giá trị, cung cấp các nguyên tắc và chiến lược để đưa ra quyết định đầu tư thông minh và bền vững.', 12, 12),
(22, 'Phân tích chứng khoán', 5, 'Benjamin Graham', '1934', 'NXB Thế Giới', '22.jpg', 'Một hướng dẫn chi tiết về cách phân tích cổ phiếu và trái phiếu, giúp nhà đầu tư hiểu rõ giá trị thực của các công cụ tài chính.', 8, 8),
(23, 'Bí mật của Phố Wall', 5, 'Peter Lynch', '1989', 'NXB Thế Giới', '23.jpg', 'Peter Lynch chia sẻ những kinh nghiệm và bài học từ sự nghiệp đầu tư thành công của mình, nhấn mạnh vào việc tận dụng lợi thế cá nhân.', 10, 10),
(24, 'Tâm lý thị trường chứng khoán', 5, 'George Soros', '1994', 'NXB Thế Giới', '24.jpg', 'George Soros phân tích tâm lý và hành vi của thị trường tài chính, giải thích cách chúng ảnh hưởng đến giá trị tài sản.', 15, 15),
(25, 'Người giàu nhất thành Babylon', 5, 'George S. Clason', '1926', 'NXB Hội Nhà Văn', '25.jpg', 'Một tập hợp các bài học tài chính thông qua những câu chuyện ngụ ngôn, giúp độc giả quản lý tiền bạc và đầu tư khôn ngoan.', 20, 20),
(26, 'Lịch sử thế giới', 6, 'H.G. Wells', '1920', 'NXB Thế Giới', '26.jpg', 'Tổng quan về lịch sử thế giới từ thời kỳ sơ khai đến hiện đại, tập trung vào những sự kiện và nhân vật quan trọng.', 10, 10),
(27, 'Sử Việt Nam qua các thời kỳ', 6, 'Trần Trọng Kim', '1941', 'Nhà xuất bản Giáo dục', '27.jpg', 'Một cái nhìn tổng quan về lịch sử Việt Nam qua các triều đại, với các sự kiện và nhân vật nổi bật.', 15, 15),
(28, 'Chiến tranh và hòa bình', 6, 'Leo Tolstoy', '1985', 'NXB Văn Học', '28.jpg', 'Một sử thi văn học mô tả sâu sắc cuộc sống trong bối cảnh chiến tranh Nga-Napoléon, với những mối quan hệ phức tạp và sự đấu tranh nội tâm.', 12, 12),
(29, 'Lịch sử Đông Nam Á', 6, 'Nicholas Tarling', '1992', 'NXB Thế Giới', '29.jpg', 'Khám phá lịch sử khu vực Đông Nam Á, từ thời tiền sử đến thời kỳ hiện đại, với các mối quan hệ quốc tế và văn hóa.', 10, 10),
(30, 'Đại Việt sử ký toàn thư', 6, 'Ngô Sĩ Liên', '1980', 'NXB Giáo Dục', '30.jpg', 'Tác phẩm sử học quan trọng ghi chép lịch sử Việt Nam từ thời Hùng Vương đến thời Hậu Lê, với nhiều sự kiện và chi tiết quan trọng.', 5, 5),
(31, 'Cẩm nang sức khỏe', 7, 'David Agus', '2015', 'NXB Trẻ', '31.jpg', 'Một hướng dẫn toàn diện về cách duy trì sức khỏe tốt thông qua lối sống và thói quen lành mạnh.', 20, 20),
(32, 'Dinh dưỡng cân bằng', 7, 'Michael Greger', '2019', 'NXB Trẻ', '32.jpg', 'Khám phá tầm quan trọng của chế độ ăn uống cân bằng và cách áp dụng kiến thức dinh dưỡng vào cuộc sống hàng ngày.', 15, 15),
(33, 'Giấc ngủ và sức khỏe', 7, 'Matthew Walker', '2017', 'NXB Trẻ', '33.jpg', 'Phân tích vai trò quan trọng của giấc ngủ đối với sức khỏe thể chất và tinh thần, dựa trên nghiên cứu khoa học hiện đại.', 10, 10),
(34, 'Những điều bác sĩ không nói với bạn', 7, 'John Abramson', '2018', 'HarperCollins', '34.jpg', 'Một cái nhìn phê phán về ngành y tế hiện đại, tập trung vào cách các quyết định kinh doanh ảnh hưởng đến sức khỏe cộng đồng.', 12, 12),
(35, 'Cẩm nang sơ cứu y tế', 7, 'Dr. Henry', '2005', 'NXB Trẻ', '35.jpg', 'Hướng dẫn thực hành sơ cứu trong các tình huống khẩn cấp, giúp người đọc tự tin xử lý các vấn đề y tế cơ bản.', 8, 8),
(36, 'Bố già', 1, 'Mario Puzo', '1969', 'NXB Thế Giới', '36.jpg', 'Tác phẩm kinh điển về thế giới mafia, kể câu chuyện về gia đình Corleone với những âm mưu, quyền lực và lòng trung thành.', 10, 10),
(37, 'Đồi gió hú', 1, 'Emily Brontë', '2000', 'NXB hội nhà văn', '37.jpg', 'Một câu chuyện tình yêu mãnh liệt và bi kịch giữa Heathcliff và Catherine, diễn ra trên bối cảnh hoang dã của vùng đồng quê nước Anh.', 8, 8),
(38, 'Những người xa lạ', 1, 'Albert Camus', '1942', 'NXB hội nhà văn', '38.jpg', 'Một tác phẩm triết học mang tính biểu tượng của chủ nghĩa hiện sinh, kể về cuộc sống của một người đàn ông xa lạ với xã hội.', 10, 10),
(39, 'Trăm năm cô đơn', 1, 'Gabriel García Márquez', '1967', 'NXB hội nhà văn', '39.jpg', 'Một kiệt tác của văn học hiện thực huyền ảo, kể về gia đình Buendía qua bảy thế hệ tại thị trấn hư cấu Macondo.', 12, 12),
(40, 'Jane Eyre', 1, 'Charlotte Brontë', '2000', 'NXB Thế Giới', '40.jpg', 'Một câu chuyện về tình yêu, sự đấu tranh và lòng tự trọng của cô gái mồ côi Jane Eyre, với những thông điệp sâu sắc về xã hội.', 15, 15),
(41, 'Vũ Trụ Trong Vỏ Hạt Dẻ', 2, 'Stephen Hawking', '2001', 'Bantam Books', '41.jpg', 'Stephen Hawking giải thích các khái niệm phức tạp về vũ trụ, bao gồm lý thuyết dây và hố đen, một cách dễ hiểu và thú vị.', 10, 10),
(42, 'Lược Sử Thời Gian', 2, 'Stephen Hawking', '1988', 'Bantam Books', '42.jpg', 'Cuốn sách kinh điển về vũ trụ học, giải thích các khái niệm từ Big Bang đến hố đen, dành cho độc giả phổ thông.', 8, 8),
(43, 'Vật Lý Lượng Tử', 2, 'David Bohm', '1980', 'Routledge', '43.jpg', 'Một cái nhìn toàn diện về vật lý lượng tử, khám phá các khía cạnh triết học và khoa học của lĩnh vực này.', 8, 8),
(44, 'Hành Trình Vào Vũ Trụ', 2, 'Neil deGrasse Tyson', '2017', 'NXB Trẻ', '44.jpg', 'Một chuyến du hành qua vũ trụ với những khám phá hấp dẫn về các hành tinh, sao và sự sống ngoài Trái Đất.', 7, 7),
(45, 'Cuộc Cách Mạng Công Nghệ 4.0', 2, 'Klaus Schwab', '2016', 'NXB Thế Giới', '45.jpg', 'Khám phá tác động của công nghệ hiện đại đến kinh tế, xã hội và đời sống, với những cơ hội và thách thức.', 9, 9),
(46, 'Người Đua Diều', 3, 'Khaled Hosseini', '2003', 'Riverhead Books', '46.jpg', 'Một câu chuyện cảm động về tình bạn, tội lỗi và sự chuộc lỗi, diễn ra tại Afghanistan đầy biến động.', 11, 11),
(47, 'Rừng Na Uy', 3, 'Haruki Murakami', '1987', 'NXB hội nhà văn', '47.jpg', 'Một câu chuyện tình yêu buồn bã và đầy cảm xúc, khám phá tâm lý phức tạp của các nhân vật trẻ tuổi.', 10, 10),
(48, 'Sông Đông Êm Đềm', 3, 'Mikhail Sholokhov', '1928', 'Nhà xuất bản Văn học', '48.jpg', 'Một tác phẩm sử thi kể về cuộc sống của người Cossack trong bối cảnh chiến tranh và cách mạng tại Nga.', 6, 6),
(49, 'Hồng Lâu Mộng', 3, 'Cao Xueqin', '2000', 'Nhà xuất bản Văn học', '49.jpg', 'Tác phẩm kinh điển của văn học Trung Quốc, mô tả sự suy tàn của một gia đình quý tộc qua những mối tình đầy bi kịch.', 12, 12),
(50, 'Kiêu Hãnh và Định Kiến', 3, 'Jane Austen', '2000', 'Nhà xuất bản Văn học', '50.jpg', 'Một câu chuyện tình yêu và sự đấu tranh giữa tầng lớp xã hội, với những thông điệp sâu sắc về nhân phẩm và lòng kiêu hãnh.', 11, 11),
(51, 'Chiến Lược Đại Dương Xanh', 4, 'W. Chan Kim & Renée Mauborgne', '2005', 'Harvard Business Review Press', '51.jpg', 'Một cách tiếp cận sáng tạo trong kinh doanh, giúp tạo ra không gian thị trường mới và tránh cạnh tranh khốc liệt.', 10, 10),
(52, 'Tư Duy Kinh Tế Học', 4, 'Steven E. Landsburg', '2008', 'Free Press', '52.jpg', 'Giải thích các nguyên tắc kinh tế học một cách thú vị và dễ hiểu, với các ví dụ từ cuộc sống hàng ngày.', 9, 9),
(53, 'Công Nghệ và Tương Lai', 4, 'Paul Krugman', '2019', 'NXB Thế Giới', '53.jpg', 'Phân tích vai trò của công nghệ trong nền kinh tế toàn cầu và tác động của nó đến sự phát triển và bất bình đẳng.', 10, 10),
(54, 'Tăng Trưởng Kinh Tế', 4, 'Robert J. Barro', '1998', 'NXB Thế Giới', '54.jpg', 'Một nghiên cứu chi tiết về các yếu tố ảnh hưởng đến tăng trưởng kinh tế và các chính sách thúc đẩy phát triển.', 12, 12),
(55, 'Đột Phá Tư Duy Kinh Doanh', 4, 'Peter Thiel', '2014', 'NXB Thế Giới', '55.jpg', 'Một hướng dẫn cho các doanh nhân để suy nghĩ khác biệt và tạo ra những doanh nghiệp đột phá.', 8, 8),
(56, 'Phương Pháp Đầu Tư Warren Buffett', 5, 'Robert G. Hagstrom', '1994', 'NXB Thế Giới', '56.jpg', 'Một cái nhìn sâu sắc về phương pháp đầu tư của Warren Buffett, tập trung vào giá trị và sự kiên nhẫn.', 10, 10),
(57, 'Nghệ Thuật Quản Lý Tài Chính', 5, 'Tony Robbins', '2014', 'NXB Thế Giới', '57.jpg', 'Một hướng dẫn toàn diện về cách quản lý tài chính cá nhân, từ đầu tư đến tiết kiệm.', 10, 10),
(58, 'Cách Nghĩ Để Thành Công', 5, 'Napoleon Hill', '1937', 'NXB Thế Giới', '58.jpg', 'Một tác phẩm kinh điển về tư duy thành công, cung cấp các nguyên tắc vượt thời gian để đạt được mục tiêu.', 8, 8),
(59, 'Làm Giàu Không Khó', 5, 'Napoleon Hill', '1937', 'NXB Thế Giới', '59.jpg', 'Hướng dẫn cách áp dụng tư duy tích cực và kiên trì để đạt được sự giàu có và thành công.', 7, 7),
(60, 'Nguyên Tắc Đầu Tư Của John Templeton', 5, 'John Templeton', '1992', 'HarperBusiness', '60.jpg', 'Một cuốn sách chia sẻ các nguyên tắc đầu tư thực tiễn từ một trong những nhà đầu tư vĩ đại nhất thế giới.', 9, 9),
(61, 'Những Cuộc Chiến Lịch Sử', 6, 'Max Hastings', '2016', 'HarperCollins', '61.jpg', 'Một cái nhìn sâu sắc về các cuộc chiến quan trọng trong lịch sử, với những bài học từ quá khứ.', 9, 9),
(62, 'Đế Chế Ottoman', 6, 'Jason Goodwin', '2002', 'Vintage', '62.jpg', 'Khám phá sự hình thành và phát triển của Đế chế Ottoman, một trong những đế chế lớn nhất lịch sử.', 11, 11),
(63, 'Sự Hưng Thịnh và Suy Tàn của Đế Quốc La Mã', 6, 'Edward Gibbon', '2000', 'Penguin Classics', '63.jpg', 'Một tác phẩm sử học nổi tiếng về sự thịnh vượng và sụp đổ của Đế quốc La Mã.', 7, 7),
(64, 'Sự Sụp Đổ Của Các Đế Chế', 6, 'Jared Diamond', '2005', 'Viking Press', '64.jpg', 'Một phân tích về lý do các nền văn minh lớn trên thế giới suy tàn, với những bài học quan trọng cho hiện tại.', 9, 9),
(65, 'Lịch Sử Các Cuộc Cách Mạng', 6, 'Eric Hobsbawm', '1996', 'NXB Thế Giới', '65.jpg', 'Một tổng quan về các cuộc cách mạng lớn trong lịch sử, với phân tích sâu sắc về động lực và tác động của chúng.', 10, 10),
(66, 'Cơ Thể Bạn Hoạt Động Như Thế Nào', 7, 'Bill Bryson', '2019', 'NXB Lao Động', '66.jpg', 'Một cuốn sách thú vị và đầy kiến thức về cách cơ thể con người hoạt động, từ các cơ quan đến tế bào.', 11, 11),
(67, 'Bí Quyết Sống Lâu', 7, 'Dan Buettner', '2008', 'NXB Trẻ', '67.jpg', 'Khám phá các bí quyết sống lâu từ những vùng đất có tuổi thọ cao nhất trên thế giới.', 8, 8),
(68, 'Dinh Dưỡng Học Hiện Đại', 7, 'T. Colin Campbell', '2005', 'NXB Trẻ', '68.jpg', 'Một nghiên cứu toàn diện về mối liên hệ giữa chế độ ăn uống và sức khỏe, dựa trên bằng chứng khoa học.', 9, 9),
(69, 'Tâm Lý Học Sức Khoẻ', 7, 'Howard S. Friedman', '1999', 'Prentice Hall', '69.jpg', 'Một cái nhìn sâu sắc về tâm lý học sức khỏe, khám phá mối quan hệ giữa tâm trí và cơ thể.', 7, 7),
(70, 'Kỹ Năng Sơ Cứu', 7, 'Joseph Alton', '2012', 'NXB lao động', '70.jpg', 'Một hướng dẫn thực hành sơ cứu y tế trong các tình huống khẩn cấp, với những kỹ năng cơ bản và nâng cao.', 8, 8);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `book_statistics`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `book_statistics`;
CREATE TABLE IF NOT EXISTS `book_statistics` (
`book_id` int
,`book_title` varchar(100)
,`borrow_count` bigint
);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `borrow`
--

DROP TABLE IF EXISTS `borrow`;
CREATE TABLE IF NOT EXISTS `borrow` (
  `borrow_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status_book` enum('borrowed','returned','overdue') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'borrowed',
  PRIMARY KEY (`borrow_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `borrow`
--

INSERT INTO `borrow` (`borrow_id`, `member_id`, `borrow_date`, `due_date`, `return_date`, `status_book`) VALUES
(1, 1, '2024-01-01', '2024-01-31', '2024-01-15', 'returned'),
(2, 2, '2024-01-03', '2024-02-02', '2024-01-17', 'returned'),
(3, 3, '2024-01-05', '2024-02-04', '2024-01-20', 'returned'),
(4, 4, '2024-12-10', '2025-01-09', NULL, 'borrowed'),
(5, 5, '2024-12-12', '2025-01-11', NULL, 'borrowed'),
(6, 6, '2024-01-15', '2024-02-14', '2024-01-25', 'returned'),
(7, 7, '2024-02-18', '2024-03-19', NULL, 'overdue'),
(8, 8, '2024-02-20', '2024-03-21', NULL, 'overdue'),
(9, 9, '2024-02-22', '2024-03-23', NULL, 'overdue'),
(10, 10, '2024-01-25', '2024-02-24', NULL, 'overdue'),
(11, 1, '2024-12-01', '2024-12-31', NULL, 'borrowed'),
(12, 2, '2024-12-03', '2025-01-02', NULL, 'borrowed'),
(13, 3, '2024-12-05', '2025-01-04', NULL, 'borrowed'),
(14, 4, '2024-12-07', '2025-01-06', NULL, 'borrowed'),
(15, 5, '2024-12-10', '2025-01-09', NULL, 'borrowed'),
(16, 6, '2024-12-12', '2025-01-11', NULL, 'borrowed'),
(17, 7, '2024-02-15', '2024-03-16', NULL, 'overdue'),
(18, 8, '2024-02-18', '2024-03-19', NULL, 'overdue'),
(19, 9, '2024-02-20', '2024-03-21', NULL, 'overdue'),
(20, 10, '2024-02-25', '2024-03-26', NULL, 'overdue'),
(21, 1, '2025-01-01', '2025-01-31', '2025-01-15', 'returned'),
(22, 3, '2025-01-05', '2025-02-04', NULL, 'borrowed'),
(23, 5, '2025-01-10', '2025-02-09', NULL, 'borrowed'),
(24, 7, '2024-02-20', '2024-03-21', NULL, 'overdue'),
(26, 2, '2024-03-15', '2024-04-14', '2024-03-22', 'returned'),
(27, 4, '2024-12-20', '2025-01-19', '2025-01-01', 'returned'),
(28, 6, '2024-12-25', '2025-01-24', NULL, 'borrowed'),
(29, 8, '2024-02-10', '2024-03-11', NULL, 'overdue'),
(30, 10, '2024-02-15', '2024-03-16', NULL, 'overdue'),
(31, 1, '2024-04-05', '2024-05-05', '2024-04-12', 'returned'),
(32, 3, '2025-01-10', '2025-02-09', NULL, 'borrowed'),
(33, 5, '2025-01-15', '2025-02-14', NULL, 'borrowed'),
(34, 7, '2024-03-25', '2024-04-24', NULL, 'overdue'),
(35, 9, '2024-03-30', '2024-04-29', NULL, 'overdue'),
(36, 2, '2024-04-20', '2024-05-20', '2025-04-27', 'returned'),
(37, 4, '2024-12-25', '2025-01-24', NULL, 'borrowed'),
(38, 6, '2024-12-30', '2025-01-29', NULL, 'borrowed'),
(39, 8, '2024-03-15', '2024-04-14', NULL, 'overdue'),
(40, 10, '2024-03-20', '2024-04-19', NULL, 'overdue'),
(41, 2, '2024-05-05', '2024-06-04', '2024-05-12', 'returned'),
(42, 4, '2023-05-10', '2023-06-09', '2023-06-01', 'returned'),
(43, 6, '2023-05-15', '2023-06-14', '2023-05-29', 'returned'),
(44, 8, '2024-04-25', '2024-05-25', NULL, 'overdue'),
(45, 10, '2024-04-30', '2024-05-30', NULL, 'overdue'),
(46, 1, '2024-05-20', '2024-06-19', '2024-05-27', 'returned'),
(47, 3, '2022-05-25', '2022-06-24', '2022-06-01', 'returned'),
(48, 5, '2024-05-30', '2024-06-29', '2024-06-15', 'returned'),
(49, 7, '2024-04-15', '2024-05-15', NULL, 'overdue'),
(50, 9, '2024-04-20', '2024-05-20', NULL, 'overdue'),
(51, 10, '2025-01-10', '2025-02-09', NULL, 'borrowed'),
(52, 9, '2025-01-10', '2025-02-09', NULL, 'borrowed'),
(53, 8, '2025-01-09', '2025-02-08', NULL, 'borrowed'),
(54, 2, '2025-01-14', '2025-02-13', NULL, 'borrowed'),
(58, 8, '2025-01-28', '2025-02-27', NULL, 'borrowed');

--
-- Bẫy `borrow`
--
DROP TRIGGER IF EXISTS `set_due_date`;
DELIMITER $$
CREATE TRIGGER `set_due_date` BEFORE INSERT ON `borrow` FOR EACH ROW BEGIN
  SET NEW.due_date = DATE_ADD(NEW.borrow_date, INTERVAL 30 DAY);
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_status_book_before_insert`;
DELIMITER $$
CREATE TRIGGER `update_status_book_before_insert` BEFORE INSERT ON `borrow` FOR EACH ROW BEGIN
  -- Default status_book when inserting a new record
  IF NEW.return_date IS NOT NULL THEN
    IF NEW.return_date <= NEW.due_date THEN
      SET NEW.status_book = 'returned'; -- Trả đúng hạn
    ELSE
      SET NEW.status_book = 'overdue'; -- Trả quá hạn
    END IF;
  ELSE
    -- Nếu chưa trả, kiểm tra nếu hiện tại quá hạn
    IF CURDATE() > NEW.due_date THEN
      SET NEW.status_book = 'overdue'; -- Quá hạn mà chưa trả
    ELSE
      SET NEW.status_book = 'borrowed'; -- Vẫn trong hạn mượn
    END IF;
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_status_book_before_update`;
DELIMITER $$
CREATE TRIGGER `update_status_book_before_update` BEFORE UPDATE ON `borrow` FOR EACH ROW BEGIN
  -- Update status_book based on return_date
  IF NEW.return_date IS NOT NULL THEN
    IF NEW.return_date <= NEW.due_date THEN
      SET NEW.status_book = 'returned'; -- Trả đúng hạn
    ELSE
      SET NEW.status_book = 'overdue'; -- Trả quá hạn
    END IF;
  ELSE
    -- Nếu chưa trả, kiểm tra nếu hiện tại quá hạn
    IF CURDATE() > NEW.due_date THEN
      SET NEW.status_book = 'overdue'; -- Quá hạn mà chưa trả
    ELSE
      SET NEW.status_book = 'borrowed'; -- Vẫn trong hạn mượn
    END IF;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `borrowdetails`
--

DROP TABLE IF EXISTS `borrowdetails`;
CREATE TABLE IF NOT EXISTS `borrowdetails` (
  `borrow_details_id` int NOT NULL AUTO_INCREMENT,
  `borrow_id` int NOT NULL,
  `book_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  PRIMARY KEY (`borrow_details_id`),
  KEY `borrow_id` (`borrow_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `borrowdetails`
--

INSERT INTO `borrowdetails` (`borrow_details_id`, `borrow_id`, `book_id`, `quantity`) VALUES
(1, 1, 36, 1),
(2, 2, 36, 1),
(3, 3, 37, 1),
(4, 4, 37, 1),
(5, 5, 38, 1),
(6, 6, 38, 1),
(7, 7, 39, 1),
(8, 8, 39, 1),
(9, 9, 40, 1),
(10, 10, 5, 1),
(11, 11, 36, 1),
(12, 12, 37, 1),
(13, 13, 38, 1),
(14, 14, 39, 1),
(15, 15, 40, 1),
(16, 16, 36, 1),
(17, 17, 37, 1),
(18, 18, 38, 1),
(19, 19, 39, 1),
(20, 20, 40, 1),
(21, 21, 1, 1),
(22, 22, 3, 1),
(23, 23, 5, 1),
(24, 24, 7, 1),
(25, 25, 9, 1),
(26, 26, 2, 1),
(27, 27, 4, 1),
(28, 28, 6, 1),
(29, 29, 8, 1),
(30, 30, 10, 1),
(31, 31, 11, 1),
(32, 32, 5, 1),
(33, 33, 5, 1),
(34, 34, 5, 1),
(35, 35, 19, 1),
(36, 36, 21, 1),
(37, 37, 56, 1),
(38, 38, 56, 1),
(39, 39, 18, 1),
(40, 40, 20, 1),
(41, 41, 21, 1),
(42, 42, 23, 1),
(43, 43, 23, 1),
(44, 44, 27, 1),
(45, 45, 5, 1),
(46, 46, 23, 1),
(47, 47, 24, 1),
(48, 48, 30, 1),
(49, 49, 30, 1),
(50, 50, 30, 1),
(51, 51, 36, 1),
(52, 52, 18, 1),
(53, 53, 18, 1),
(54, 54, 7, 1),
(55, 55, 2, 1),
(56, 56, 2, 1),
(57, 57, 2, 1),
(58, 58, 2, 1),
(59, 59, 7, 1),
(60, 60, 7, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Tiểu thuyết'),
(2, 'Khoa học và công nghệ'),
(3, 'Văn học'),
(4, 'Kinh tế'),
(5, 'Đầu tư'),
(6, 'Lịch sử'),
(7, 'Y học và chăm sóc sức khoẻ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lost_book`
--

DROP TABLE IF EXISTS `lost_book`;
CREATE TABLE IF NOT EXISTS `lost_book` (
  `lost_id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `book_id` int NOT NULL,
  `lost_date` date NOT NULL,
  `compensation_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`lost_id`),
  KEY `member_id` (`member_id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `course_year` varchar(50) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `student_id` (`student_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `member`
--

INSERT INTO `member` (`member_id`, `student_id`, `full_name`, `email`, `class`, `course_year`, `password_hash`) VALUES
(1, 'admin01', 'Phú Sang', 'sang@example.com', 'DH38CDS01', '38', 'password_1'),
(2, 'SV001', 'Xuân Vũ', 'vu@example.com', 'DH38CDS01', '38', 'password_2'),
(3, 'SV002', 'Hoài Duyên', 'duyen@gmail.com', 'DH38CDS02', '38', 'password_3'),
(4, 'SV003', 'Mỹ Uyên', 'uyen@gmail.com', 'DH38CDS01', '38', 'password_4'),
(5, 'SV004', 'Thu Thảo', 'thao@gmail.com', 'DH38CDS02', '38', 'password_5'),
(6, 'SV005', 'Duy Đoàn', 'doan@gmail.com', 'DH38CDS02', '38', 'password_6'),
(7, 'SV006', 'Ngô Văn Giang', 'ngovang@gmail.com', 'DH40CDS01', '40', 'password_7'),
(8, 'SV007', 'Bùi Thị Huệ', 'buithih@gmail.com', 'DH39CDS02', '39', 'password_8'),
(9, 'SV008', 'Phan Văn Lộc', 'phanvani@gmail.com', 'DH39CDS02', '39', 'password_9'),
(10, 'SV009', 'Vũ Thị Kim', 'vuthik@gmail.com', 'DH40CDS02', '40', 'password_10'),
(12, '13', 'test', 'test@gmail.com', 'DH38CDS02', '39', 'abc');

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `overdue_members`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `overdue_members`;
CREATE TABLE IF NOT EXISTS `overdue_members` (
`member_id` int
,`full_name` varchar(100)
,`class` varchar(50)
,`course_year` varchar(50)
,`borrow_id` int
,`book_id` int
,`book_title` varchar(100)
,`borrow_date` date
,`return_date` date
);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','student') NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `role`) VALUES
(1, 'admin01', 'admin01', 'admin'),
(2, 'SV001', 'password_1', 'student'),
(3, 'SV002', 'password_2', 'student'),
(4, 'SV003', 'password_3', 'student'),
(5, 'SV004', 'password_4', 'student'),
(6, 'SV005', 'password_5', 'student'),
(7, 'SV006', 'password_6', 'student'),
(8, 'SV007', 'password_7', 'student'),
(9, 'SV008', 'password_8', 'student'),
(10, 'SV009', 'password_9', 'student'),
(11, 'SV010', 'password_10', 'student'),
(12, 'admin02', 'admin02', 'admin'),
(13, 'admin03', 'admin03', 'admin'),
(14, 'admin04', 'admin04', 'student'),
(15, 'SV111', '123', 'student'),
(17, '13', 'abc', 'student');

-- --------------------------------------------------------

--
-- Cấu trúc cho view `book_statistics`
--
DROP TABLE IF EXISTS `book_statistics`;

DROP VIEW IF EXISTS `book_statistics`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `book_statistics`  AS SELECT `b`.`book_id` AS `book_id`, `b`.`book_title` AS `book_title`, count(`bd`.`book_id`) AS `borrow_count` FROM (`book` `b` left join `borrowdetails` `bd` on((`b`.`book_id` = `bd`.`book_id`))) GROUP BY `b`.`book_id` ORDER BY `borrow_count` DESC ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `overdue_members`
--
DROP TABLE IF EXISTS `overdue_members`;

DROP VIEW IF EXISTS `overdue_members`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `overdue_members`  AS SELECT `m`.`member_id` AS `member_id`, `m`.`full_name` AS `full_name`, `m`.`class` AS `class`, `m`.`course_year` AS `course_year`, `b`.`borrow_id` AS `borrow_id`, `bd`.`book_id` AS `book_id`, `bk`.`book_title` AS `book_title`, `b`.`borrow_date` AS `borrow_date`, `b`.`return_date` AS `return_date` FROM (((`member` `m` join `borrow` `b` on((`m`.`member_id` = `b`.`member_id`))) join `borrowdetails` `bd` on((`b`.`borrow_id` = `bd`.`borrow_id`))) join `book` `bk` on((`bd`.`book_id` = `bk`.`book_id`))) WHERE (`b`.`status_book` = 'overdue') ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
