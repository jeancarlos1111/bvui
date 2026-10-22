import * as pdfjsLib from 'pdfjs-dist';
import pdfjsWorker from 'pdfjs-dist/build/pdf.worker.mjs?url';
import Chart from 'chart.js/auto';

pdfjsLib.GlobalWorkerOptions.workerSrc = pdfjsWorker;
window.pdfjsLib = pdfjsLib;
window.Chart = Chart;
