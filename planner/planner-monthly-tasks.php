<?php
function planner_monthly_task_template(TCPDF $pdf, float $margin, float $line_size): void
{
    [$start_x, $start_y, $width, $height] = planner_size_dimensions($margin);
    $start_y += planner_monthly_extra_day_link_height();
    $height -= planner_monthly_extra_day_link_height();

    $half_width = ($width - $margin) / 2;

    planner_draw_note_area($pdf, $start_x, $start_y, $half_width, $height, 'checkbox', $line_size);
    planner_draw_note_area($pdf, $start_x + $margin + $half_width, $start_y, $half_width, $height, 'checkbox', $line_size);
}

Templates::register('planner-monthly-task', 'planner_monthly_task_template');

function planner_monthly_task(TCPDF $pdf, Month $month): void
{
    [$tabs, $tab_targets] = planner_make_monthly_tabs($pdf, $month);

    $pdf->AddPage();
    $pdf->setLink(Links::monthly($pdf, $month, 'task'));

    planner_monthly_header($pdf, $month, 2, $tabs);
    link_tabs($pdf, $tabs, $tab_targets);

    $margin = 2;
    $line_size = 6;

    Templates::draw('planner-monthly-task', $margin, $line_size);

    planner_nav_sub($pdf, $month->days[0]->month(), $month->days[6]->month());
    planner_nav_main($pdf, 0);
}