function formatDateBR(date) {
	var parts = date.split("/");
	var day = parts[0];
	var month = parts[1];
	var year = parseInt(parts[2], 10);

	// Convert year to four digits
	if (year < 1000) {
		year = year + 2000;
	}

	return "".concat(day, "/").concat(month, "/").concat(year);
}

export { formatDateBR };
