function formatterCurrency(language, currency, value) {
	return new Intl.NumberFormat(language, {
		style: "currency",
		currency: currency,
	}).format(value);
}

export { formatterCurrency };
