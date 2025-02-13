import puppeteer from 'puppeteer';

(async () => {
    const args = process.argv.slice(2);
    const url = args[0];

    if (!url) {
        console.error('URL is required');
        process.exit(1);
    }

    const browser = await puppeteer.launch({
        headless: false, // Используем новый headless режим
        executablePath: '/var/www/alexkovalev__usr/data/.cache/puppeteer/chrome/linux-133.0.6943.53/chrome-linux64/chrome', // Укажите путь
        args: [
            '--no-sandbox',               // Убирает ограничения в sandbox
            '--disable-setuid-sandbox',   // Отключает sandbox
            '--disable-gpu',              // Отключаем GPU (не нужно в headless режиме)
            '--disable-extensions',       // Отключаем расширения
            '--disable-dev-shm-usage',    // Убираем использование /dev/shm
            '--no-zygote',                // Отключаем zygote (поток изоляции)
            '--single-process'            // Запуск в отдельном процессе
        ],
    });

    //const browser = await puppeteer.launch();
    const page = await browser.newPage();

    await page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36');
    await page.goto(url, {waitUntil: 'networkidle2'});

    try {
        // Ищем кнопку с атрибутом label="Принять все"
        await page.waitForSelector('button[aria-label="Принять все"]', {timeout: 5000});
        const [button] = await page.$$('button[aria-label="Принять все"]'); // На случай если кнопка вызывает новый переход
        if (button) {
            const navigationPromise = page.waitForNavigation({waitUntil: 'load', timeout: 10000}); // Ждем навигации
            await button.click();
            await navigationPromise; // Ожидаем завершение смены страницы
            console.log('Cookie banner button clicked and navigation completed.');
        }
    } catch (error) {
        console.log('No cookie banner button found or timed out.', error);
    }

    try {
        const content = await page.content();
        console.log(content);
    } catch (error) {
        console.error('Error fetching page content:', error);
    }

    await browser.close();
})();
