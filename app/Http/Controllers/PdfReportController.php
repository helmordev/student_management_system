<?php

namespace App\Http\Controllers;

use App\Services\PdfReportService;
use Illuminate\Http\Request;

class PdfReportController extends Controller
{
    protected $pdfReportService;

    public function __construct(PdfReportService $pdfReportService)
    {
        $this->pdfReportService = $pdfReportService;
    }

    public function generateStudentListReport(Request $request)
    {
        return $this->pdfReportService->generateStudentListReport($request->all());
    }

    public function generateStudentGradesReport($studentId)
    {
        return $this->pdfReportService->generateStudentGradesReport($studentId);
    }

    public function generateGradeSummaryReport(Request $request)
    {
        return $this->pdfReportService->generateGradeSummaryReport($request->all());
    }
}
