<?
$aMenuLinks = Array(
	Array(
		"Компания", 
		"/about/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Сотрудники", 
		"/company/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Диски", 
		"/docs/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('CommonDocuments')" 
	),
	Array(
		"Сервисы", 
		"/services/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Группы", 
		"/workgroups/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('Workgroups')" 
	),
	Array(
		"Время и отчеты", 
		"/timeman/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Бизнес-процессы", 
		"/bizproc/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('BizProc')" 
	),
	Array(
		"CRM", 
		"/crm/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('crm') && CModule::IncludeModule('crm') && CCrmPerms::IsAccessEnabled()" 
	),
	Array(
		"Приложения", 
		"/marketplace/", 
		Array(), 
		Array(), 
		"IsModuleInstalled('rest')" 
	),
    Array(
        "Test",
        "/test/",
        Array(),
        Array(),
        ""
    )
);
?>