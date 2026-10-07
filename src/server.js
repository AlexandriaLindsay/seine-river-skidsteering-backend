import 'dotenv/config'
import express from 'express'
import cors from 'cors'
import nodemailer from 'nodemailer'
import { getTransporter, wasTestAccountUsed } from './mailer.js'

const app = express()

const corsOrigin = process.env.CORS_ORIGIN ?? '*'
app.use(cors({ origin: corsOrigin }))
app.use(express.json())

const TO_EMAIL = process.env.TO_EMAIL ?? 'cal@srskidsteering.ca'

app.get('/api/health', (_req, res) => {
  res.json({ ok: true })
})

app.post('/api/contact', async (req, res) => {
  const { name, email, phone, service_interested, message, website } = req.body ?? {}

  // Honeypot — bots tend to fill every field, real users never see this one.
  if (website) {
    return res.status(204).end()
  }

  if (!name || !email || !message) {
    return res.status(422).json({ message: 'Name, email, and message are required.' })
  }

  const subject = `New website submission from ${name}`
  const text = [
    `Name: ${name}`,
    `Email: ${email}`,
    `Phone: ${phone || 'Not provided'}`,
    `Service: ${service_interested || 'Not specified'}`,
    '',
    message,
  ].join('\n')

  try {
    const transporter = await getTransporter()
    const info = await transporter.sendMail({
      from: process.env.SMTP_FROM ?? `"SRS Website" <${process.env.SMTP_USER ?? TO_EMAIL}>`,
      to: TO_EMAIL,
      replyTo: email,
      subject,
      text,
    })

    const response = { message: 'Sent.' }
    if (wasTestAccountUsed()) {
      response.previewUrl = nodemailer.getTestMessageUrl(info)
    }
    res.status(201).json(response)
  } catch (err) {
    console.error('Failed to send contact email:', err)
    res.status(502).json({ message: 'Could not send message. Please try again or call us directly.' })
  }
})

const port = process.env.PORT ?? 3001
app.listen(port, () => {
  console.log(`Backend listening on port ${port}`)
})
