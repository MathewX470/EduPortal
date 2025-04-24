SELECT 
    s.subjectName,
    COUNT(CASE WHEN a.status = 'present' THEN 1 END) AS Attended_Class,
    COUNT(CASE WHEN a.status = 'absent' THEN 1 END) AS absent_count,
    COUNT(CASE WHEN a.status = 'dl' THEN 1 END) AS dl_count,
    COUNT(*) AS total_classes
FROM 
    attendance a
JOIN 
    student st ON a.studentID = st.studID
JOIN 
    timetable t ON t.classID = st.classID 
        AND t.periodNumber = a.periodNumber 
        AND DAYNAME(a.date) = t.dayOfWeek
JOIN 
    subject s ON s.facultyID = t.facultyID
WHERE 
    a.studentID = 1  -- Replace with the desired studID
GROUP BY 
    s.subjectName
ORDER BY 
    s.subjectName;


    DROP TABLE IF EXISTS `leaveapplication`;
CREATE TABLE IF NOT EXISTS `leaveapplication` (
  `leaveID` int NOT NULL AUTO_INCREMENT,
  `studID` int NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `reason` varchar(100) NOT NULL,
  `filePath` varchar(255) DEFAULT NULL, -- Stores the path or name of the uploaded file
  `status` enum('approved','rejected','pending') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`leaveID`),
  KEY `leaveApply_student_fk` (`studID`),
  CONSTRAINT `leaveApply_student_fk` FOREIGN KEY (`studID`) REFERENCES `student` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;