import { Head, useForm } from '@inertiajs/react';
import { useEffect } from 'react';
import { Html5QrcodeScanner } from "html5-qrcode";
import AuthLayout from '@/layouts/auth-layout';
import { Card, CardContent, CardHeader } from '@/components/ui/card';
import { Inertia } from "@inertiajs/inertia";

// If you use Ziggy for route() helper, import it
// import route from 'ziggy-js';

export default function Login({ status, canResetPassword }) {
    const { post, setData } = useForm({
        qr_code: ''
    });

    useEffect(() => {
        const scanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: { width: 250, height: 250 } },
            false
        );

        function onScanSuccess(decodedText: string, decodedResult: any) {
            setData('qr_code', decodedText);
           Inertia.post('/login_qr', { qr_code: decodedText });
            scanner.clear();
        }

        function onScanFailure(error: any) {
            // Ignore scan failures
        }

        scanner.render(onScanSuccess, onScanFailure);

        return () => {
            scanner.clear().catch(() => {});
        };
    }, [post, setData]);

    return (
        <AuthLayout title="Log in to Your account" description="Scan your QR code to Log In">
            <Head title="Log in" />
            <Card className="w-full max-w-md">
                <CardHeader className="space-y-1" />
                <CardContent>
                    <div id="reader"></div>
                </CardContent>
            </Card>
        </AuthLayout>
    );
}
