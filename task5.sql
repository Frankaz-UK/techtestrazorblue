SELECT 
	u.username,
	u.email,
	SUM(o.amount) AS Total
FROM users u
JOIN orders o ON o.user_id = u.id
GROUP BY u.id
ORDER BY Total DESC;