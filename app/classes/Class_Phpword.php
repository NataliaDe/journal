<?php
/**
 * Object model mapping for relational table `ss.regions`
 */
namespace App\CLASSES;

use \RedBeanPHP\Facade as R;



class Class_Phpword
{
    const style_cell_center = array('valign' => 'center', 'align' => 'center');
    const style_cell_font = array('size' => 12);
    const style_cell_left = array('align' => 'left');
    const cell_center = array('valign' => 'center', 'align' => 'center');
    const cellColSpan_4 = array('gridSpan' => 4, 'valign' => 'center', 'align' => 'center');
    const cellColSpan_3 = array('gridSpan' => 3, 'valign' => 'center', 'align' => 'center');
    const cellColSpan = array('gridSpan' => 2, 'valign' => 'center', 'align' => 'center');
    const cellColSpan_6 = array('gridSpan' => 6, 'valign' => 'center', 'align' => 'center');
    const cellColSpan_1 = array('gridSpan' => 1, 'valign' => 'center', 'align' => 'center');
    const cellColSpan_10 = array('gridSpan' => 10, 'valign' => 'center', 'align' => 'center');
    const cellColSpan_10_yellow = array('gridSpan' => 10, 'valign' => 'center', 'align' => 'center',"bgColor"=>"yellow");
    const cellColSpan_11_yellow = array('gridSpan' => 11, 'valign' => 'center', 'align' => 'center',"bgColor"=>"yellow");
    const cellColSpan_12 = array('gridSpan' => 12, 'valign' => 'center', 'align' => 'center');
    const cellColSpan_2 = array('gridSpan' => 2, 'valign' => 'center', 'align' => 'center');
    const cellColSpan_11 = array('gridSpan' => 11, 'valign' => 'center', 'align' => 'center');
    const cellColSpan_9 = array('gridSpan' => 9, 'valign' => 'center', 'align' => 'center');
    const cellTextCentered = array('align' => 'center', 'size' => 8,);
    const cellTextCenteredFont = array('align' => 'center', 'size' => 8);
    const cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'align' => 'center');
    const cellRowContinue = array('vMerge' => 'continue');
    //const cellVCenteredCellBTLR = array('valign' => 'center', 'textDirection' => PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR, 'exactHeight' => 10000);
    const cellHCentered = array('align' => 'center', 'size' => 11);
    const header_style_cell_size = array('size' => 15);
    //const header_style_cell_font =array('space' => array('line' => 28, 'rule' => 'exact'));
    //'spaceAfter' => 0,
    const header_style_cell_font = array('spaceAfter'      => 0, 'spacing'         => 280,
        'spacingLineRule' => 'exact');
    const start_descr_font = array('spaceAfter' => 0, 'spacing' => 0,'align'=>'both');
}

?>