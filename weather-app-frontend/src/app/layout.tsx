import '@rippleui/core/dist/style.css';
import type { Metadata } from "next";
import "./globals.css";
// import { Toaster } from "rippleui"; // Removed as 'Toaster' is not exported from 'rippleui'

export const metadata: Metadata = {
  title: "Weather App | Pawa IT Assessment",
  description: "Weather application built for Pawa IT technical assessment",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" suppressHydrationWarning>
      <head>
        {/* Additional head elements can go here */}
      </head>
      <body className="font-sans antialiased bg-gray-50 text-gray-900">
        {children}
        {/* <Toaster /> Removed as 'Toaster' is not exported from 'rippleui' */}
      </body>
    </html>
  );
}
