import nodemailer from 'nodemailer'

let cachedTransporter = null
let isTestAccount = false

export async function getTransporter() {
  if (cachedTransporter) return cachedTransporter

  if (process.env.SMTP_HOST) {
    cachedTransporter = nodemailer.createTransport({
      host: process.env.SMTP_HOST,
      port: Number(process.env.SMTP_PORT ?? 587),
      secure: process.env.SMTP_SECURE === 'true',
      auth: {
        user: process.env.SMTP_USER,
        pass: process.env.SMTP_PASS,
      },
    })
    return cachedTransporter
  }

  // No SMTP configured (e.g. local dev before SiteGround mailbox exists) —
  // fall back to an Ethereal test inbox so the flow is still testable end-to-end.
  const testAccount = await nodemailer.createTestAccount()
  isTestAccount = true
  cachedTransporter = nodemailer.createTransport({
    host: testAccount.smtp.host,
    port: testAccount.smtp.port,
    secure: testAccount.smtp.secure,
    auth: {
      user: testAccount.user,
      pass: testAccount.pass,
    },
  })
  console.warn(
    '[mailer] SMTP_HOST not set — using a temporary Ethereal test inbox. Set SMTP_* env vars for real delivery.',
  )
  return cachedTransporter
}

export function wasTestAccountUsed() {
  return isTestAccount
}
