<?php
// Sub-type readable labels mapping for the entire application
$subTypeLabels = [
    'founder_ceo'           => 'Founder & CEO',
    'cofounder_cto'         => 'Co-Founder & CTO',
    'coo'                   => 'Chief Operations Officer',
    'cmo'                   => 'Chief Marketing Officer',
    'cso'                   => 'Chief Scientific Officer',
    'cro'                   => 'Chief Research Officer',
    'president'             => 'President',
    'director'              => 'Director',
    'principal_investigator'=> 'Principal Investigator',
    'research_director'     => 'Research Director',
    'research_associate'    => 'Research Associate',
    'phd_scholar'           => 'PhD Scholar',
    'grad_researcher'       => 'Graduate Researcher',
    'lab_assistant'         => 'Lab Assistant',
    'data_analyst'          => 'Data Analyst',
    'software_engineer'     => 'Software Engineer',
    'project_coordinator'   => 'Project Coordinator',
    'research_intern'       => 'Research Intern',
    'content_specialist'    => 'Content Specialist',
    'technical_writer'      => 'Technical Writer',
];

// Role groupings for forms
$roleGroups = [
    'leader' => [
        'founder_ceo', 'cofounder_cto', 'coo', 'cmo', 'cso', 'cro', 'president', 'director', 'principal_investigator', 'research_director'
    ],
    'team_member' => [
        'research_associate', 'phd_scholar', 'grad_researcher', 'lab_assistant', 'data_analyst', 'software_engineer', 'project_coordinator', 'research_intern', 'content_specialist', 'technical_writer'
    ]
];

function getSubTypeLabel($subType) {
    global $subTypeLabels;
    if (isset($subTypeLabels[$subType])) {
        return $subTypeLabels[$subType];
    }
    return !empty($subType) ? ucfirst(str_replace('_', ' ', $subType)) : '';
}
?>
